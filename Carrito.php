<?php
require_once 'DAO/DAOCarrito.php';

// Inicializamos el DAO del carrito
$daoCarrito = new DAOCarrito();

// ID del carrito actual (puedes obtenerlo dinámicamente según el usuario)
$idCarrito = 1;

// Obtener productos del carrito
$cartItems = $daoCarrito->obtenerProductosDelCarrito($idCarrito);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="./css/carrito.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="/image/logo.png" alt="Logo El rincón del coleccionista">
        </div>
        <h1>Carrito de compras</h1>
    </header>

    <div class="container">
        <!-- Carrito de compras -->
        <div class="carrito">
            <h2>Carrito</h2>
            <button onclick="vaciarCarrito()">Vaciar carrito</button>
            <table id="cart-table">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $subtotal = 0;
                    foreach ($cartItems as $item) {
                        $subtotal += $item['cantidad'] * $item['precio_unitario'];
                        echo "
                        <tr>
                            <td>{$item['nombre']}</td>
                            <td>{$item['cantidad']}</td>
                            <td>L{$item['precio_unitario']}</td>
                            <td><button onclick='eliminarProducto({$item['id_articulo']})'>🗑️</button></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Factura -->
        <div class="factura">
            <h2>Factura</h2>
            <div class="factura-info">
                <label for="nombre">Nombre del cliente:</label>
                <input type="text" id="nombre" placeholder="Nombre">

                <label for="apellido">Apellido del cliente:</label>
                <input type="text" id="apellido" placeholder="Apellido">

                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" placeholder="Usuario">

                <label for="vendedor">Nombre del vendedor:</label>
                <input type="text" id="vendedor" placeholder="Vendedor">

                <label for="factura-id">Código de factura:</label>
                <input type="text" id="factura-id" value="FAC<?php echo rand(1000, 9999); ?>" readonly>

                <label for="subtotal">Subtotal:</label>
                <input type="text" id="subtotal" value="L<?php echo $subtotal; ?>" readonly>

                <label for="total">Total:</label>
                <input type="text" id="total" value="L<?php echo $subtotal; ?>" readonly>
            </div>
        </div>
    </div>

    <footer>
        <button onclick="finalizarCompra()">Finalizar compra</button>
    </footer>

    <script>
        function eliminarProducto(idProducto) {
            const idCarrito = 1;

            fetch('carritoController.php?action=eliminar', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `idCarrito=${idCarrito}&idProducto=${idProducto}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    window.location.reload(); // Recargar la página
                } else {
                    alert('Error al eliminar el producto.');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function vaciarCarrito() {
            fetch('carritoController.php?action=obtener&idCarrito=1')
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => eliminarProducto(item.id_articulo));
                })
                .catch(error => console.error('Error:', error));
        }

        function finalizarCompra() {
            const nombre = document.getElementById('nombre').value;
            const apellido = document.getElementById('apellido').value;
            const usuario = document.getElementById('usuario').value;
            const vendedor = document.getElementById('vendedor').value;

            if (nombre && apellido && usuario && vendedor) {
                fetch('carritoController.php?action=finalizar', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `nombre=${nombre}&apellido=${apellido}&usuario=${usuario}&vendedor=${vendedor}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        vaciarCarrito(); // Vaciar el carrito después de finalizar la compra
                    } else {
                        alert('Error al procesar la compra.');
                    }
                })
                .catch(error => console.error('Error:', error));
            } else {
                alert('Por favor complete todos los campos para finalizar la compra.');
            }
        }
    </script>
</body>
</html>
