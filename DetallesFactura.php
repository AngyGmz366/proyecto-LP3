<?php
require_once 'FacturaController.php';
require_once 'DAO/DAOFactura.php';
require_once 'BD/factura.php';
require_once 'BD/detalle_factura.php';

// Verificar que los datos lleguen correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreCliente = $_POST['nombre_cliente'];
    $nombreVendedor = $_POST['nombre_vendedor'];
    $moneda = $_POST['moneda'];
    $carrito = json_decode($_POST['carrito'], true); // Carrito enviado como JSON

    $facturaManager = new FacturaController();
    $resultado = $facturaManager->crearFacturaConDetalles($nombreCliente, $nombreVendedor, $moneda, $carrito);

    // Retornar respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($resultado);
}  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="./css/factura.css">
    <header>
        <div class="logo">
         <img src="./image/logo.png" alt="Logo">
        </div>
       <h1>Factura</h1>
   
    </header>
    <button onclick="window.location.href='home.php'">Volver</button>

    <script>
        
        // Función para calcular y mostrar subtotal y total
        function calcularTotales() {
            let subtotal = 0;
            carrito.forEach(producto => {
                subtotal += producto.cantidad * producto.precio_unitario;
            });
            let impuesto = subtotal * 0.15; // 15% de impuesto
            let total = subtotal + impuesto;

            document.getElementById("subtotal").value = "L" + subtotal.toFixed(2);
            document.getElementById("total").value = "L" + total.toFixed(2);
        }

        // Renderiza la tabla del carrito
        function renderizarCarrito() {
            const tbody = document.getElementById("carrito-detalle");
            tbody.innerHTML = ""; // Limpiar la tabla

            carrito.forEach(producto => {
                let fila = `
                    <tr>
                        <td>${producto.nombre}</td>
                        <td>${producto.cantidad}</td>
                        <td>L${producto.precio_unitario.toFixed(2)}</td>
                        <td>L${(producto.cantidad * producto.precio_unitario).toFixed(2)}</td>
                    </tr>
                `;
                tbody.innerHTML += fila;
            });

            calcularTotales();
        }

        // Enviar la factura al backend
        function generarFactura() {
            const nombreCliente = document.getElementById("nombre").value;
            const nombreVendedor = document.getElementById("vendedor").value;
            const moneda = document.getElementById("moneda").value;

            if (!nombreCliente || !nombreVendedor) {
                alert("Por favor, llena todos los campos requeridos.");
                return;
            }

            fetch("crear_factura.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    nombre_cliente: nombreCliente,
                    nombre_vendedor: nombreVendedor,
                    moneda: moneda,
                    carrito: JSON.stringify(carrito)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert("Factura creada correctamente.\nTotal: " + moneda + data.factura.total.toFixed(2));
                } else {
                    alert("Error: " + data.mensaje);
                }
            })
            .catch(err => console.error("Error:", err));
        }

        // Inicializa la página
        document.addEventListener("DOMContentLoaded", () => {
            renderizarCarrito();
        });
    </script>
</head>
<body>
    <div class="factura">
        
        <div class="factura-info">
            <label for="nombre">Nombre del cliente:</label>
            <input type="text" id="nombre" placeholder="Nombre del cliente" required>

            <label for="vendedor">Nombre del vendedor:</label>
            <input type="text" id="vendedor" placeholder="Nombre del vendedor" required>

            <label for="moneda">Moneda de pago:</label>
            <select id="moneda">
                <option value="L">Lempira (L)</option>
                <option value="$">Dólar ($)</option>
                <option value="€">Euro (€)</option>
            </select>

            <h3>Detalles del Carrito</h3>
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="carrito-detalle"></tbody>
            </table>

            <label for="subtotal">Subtotal:</label>
            <input type="text" id="subtotal" value="L0.00" readonly>

            <label for="total">Total:</label>
            <input type="text" id="total" value="L0.00" readonly>

            <button onclick="generarFactura()">Generar Factura</button>
            
        </div>
    </div>
    <script>
        
        // Función generarFactura
        function generarFactura() {
            const nombreCliente = document.getElementById("nombre").value;
            const nombreVendedor = document.getElementById("vendedor").value;
            const moneda = document.getElementById("moneda").value;

            if (!nombreCliente || !nombreVendedor) {
                alert("Por favor, llena todos los campos requeridos.");
                return;
            }
            
            fetch("crear_factura.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    nombre_cliente: nombreCliente,
                    nombre_vendedor: nombreVendedor,
                    moneda: moneda,
                    carrito: JSON.stringify(carrito) // Enviar el carrito como JSON
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert("Factura creada correctamente.\nTotal: " + moneda + data.factura.total.toFixed(2));
                } else {
                    alert("Error: " + data.mensaje);
                }
            })
            .catch(err => console.error("Error:", err));
        }
    </script>
</body>
</html>

