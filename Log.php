<?php
require_once 'DAO/DAOCliente.php';
require_once 'DAO/DAOArticulo.php';

$daoCliente = new DAOCliente();
$daoArticulo = new DAOArticulo();

$totalClientes = $daoCliente->obtenerTotalClientes();
$clientesPorMembresia = $daoCliente->clientesPorMembresia();
$totalArticulos = $daoArticulo->obtenerTotalArticulos();
$articulosPorCategoria = $daoArticulo->articulosPorCategoria();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Estadísticas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/estadisticas.css">

</head>
<body>
   <header>
        <div class="logo">
            <img src="./image/logo.png" alt="Logo de la Empresa">
        </div>
        <h1>Gestión de estadisticas</h1>
    </header>
    <button onclick="window.location.href='homeEmpleados.php'">Volver</button>

    <div class="container">
        <div class="estadistica">
         <h2>Clientes</h2>
         <p>Total de Clientes: <?php echo $totalClientes; ?></p>
         <canvas id="graficoClientes"></canvas>
        
            <script>
             const datosClientes = <?php echo json_encode($clientesPorMembresia); ?>;
             const etiquetasClientes = datosClientes.map(d => d.membresia);
             const valoresClientes = datosClientes.map(d => d.cantidad);

                new Chart(document.getElementById('graficoClientes'), {
                    type: 'pie',
                    data: {
                        labels: etiquetasClientes,
                        datasets: [{
                         data: valoresClientes,
                         backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56']
                        }]
                    }
                });
             </script>

    
    
        </div>
        <div class="estadistica">
         <h2>Artículos</h2>
         <p>Total de Artículos: <?php echo $totalArticulos; ?></p>
         <canvas id="graficoArticulos"></canvas>
            <script>
             const datosArticulos = <?php echo json_encode($articulosPorCategoria); ?>;
             const etiquetasArticulos = datosArticulos.map(d => d.id_categoria_fk);
             const valoresArticulos = datosArticulos.map(d => d.cantidad);

                new Chart(document.getElementById('graficoArticulos'), {
                   type: 'bar',
                    data: {
                        labels: etiquetasArticulos,
                        datasets: [{
                          label: 'Cantidad por Categoría',
                          data: valoresArticulos,
                          backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56']
                        }]
                    }
                });
            </script>
        </div>
    </div>
</body>
</html>
