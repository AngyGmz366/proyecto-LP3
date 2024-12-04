<?php
require_once 'DAO/DAOCarrito.php';
require_once 'DAO/DAODetalleCarrito.php';
session_start();

$articulosCarrito = [];
$error = "";

try {
    $daoCarrito = new DAOCarrito();
    $daoDetalleCarrito = new DAODetalleCarrito();

    // Verificar si hay un carrito activo
    $carrito = $daoCarrito->obtenerCarritoActual();
    if ($carrito) {
        $idCarrito = $carrito->getIdCarritoPk();
        // Obtener detalles del carrito
        $articulosCarrito = $daoDetalleCarrito->obtenerDetallesPorCarrito($idCarrito);
    }
} catch (Exception $e) {
    $error = "Error al cargar el carrito: " . $e->getMessage();
}
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
            <img src="./image/logo.png" alt="Logo El rincón del coleccionista">
        </div>
        <h1>Carrito de compras</h1>
    </header>
    <button onclick="window.location.href='home.php'">Volver</button>

    <div class="container">
        <div class="carrito">
            <h2>Carrito</h2>
            <button onclick="vaciarCarrito()">Vaciar carrito</button>
            <table id="cart-table">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($articulosCarrito)): ?>
                        <?php foreach ($articulosCarrito as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nombreArticulo']) ?></td>
                                <td><?= htmlspecialchars($item['cantidad']) ?></td>
                                <td>L<?= htmlspecialchars(number_format($item['precio'], 2)) ?></td>
                                <td>L<?= htmlspecialchars(number_format($item['cantidad'] * $item['precio'], 2)) ?></td>
                                <td>
                                    <button onclick="eliminarProducto(<?= $item['idDetalle'] ?>)">🗑️</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">El carrito está vacío.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
     <button onclick="window.location.href='DetallesFactura.php'">Generar factura</button>
    </footer>

    <script>
        // Función para eliminar un producto del carrito
        function eliminarProducto(idDetalle) {
           
         window.location.href = `eliminarDetalleCarrito.php?id=${idDetalle}`;
            
        }

        // Función para vaciar el carrito
        function vaciarCarrito() {
            
            window.location.href = 'vaciarCarrito.php';
            
        }

        // Función para finalizar la compra
        function finalizarCompra() {
            alert('Compra finalizada exitosamente.');
        }
    </script>
</body>
</html>
