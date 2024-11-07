<?php
require_once 'DAO/DAOEmpleado.php';
require_once 'Empleado.php';
require_once 'DAO/DAOTipoEmpleado.php'; // Asegúrate de tener esta clase para obtener los tipos de empleados
require_once 'DAO/DAOUsuario.php'; // Asegúrate de tener esta clase para obtener los usuarios
require_once 'DAO/DAOTienda.php'; // Asegúrate de tener esta clase para obtener las tiendas

$daoEmpleado = new DAOEmpleado();
$daoUsuario = new DAOUsuario();
$daoTipoEmpleado = new DAOTipoEmpleado();
$daoTienda = new DAOTienda();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha_contratacion = $_POST['fecha_contratacion'];
    $id_tipo_empleado_fk = $_POST['id_tipo_empleado_fk'];
    $id_usuario_fk = $_POST['id_usuario_fk'];
    $id_tienda_fk = $_POST['id_tienda_fk'];

    $empleado = new Empleado(null, $fecha_contratacion, $id_tipo_empleado_fk, $id_usuario_fk, $id_tienda_fk);

    try {
        if ($daoEmpleado->agregarEmpleado($empleado)) {
            echo "Empleado agregado exitosamente.";
        } else {
            echo "Error al agregar el empleado.";
        }
    } catch (Exception $e) {
        echo "Excepción capturada: " . $e->getMessage();
    }
}

$empleados = $daoEmpleado->obtenerEmpleados();
$usuarios = $daoUsuario->obtenerTodosLosUsuarios(); // Obtener todos los usuarios para la lista desplegable
$tiposEmpleados = $daoTipoEmpleado->obtenerTodosLosTiposEmpleado(); // Obtener todos los tipos de empleados para la lista desplegable
$tiendas = $daoTienda->obtenerTodasLasTiendas(); // Obtener todas las tiendas para la lista desplegable
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <header>
        <div class="logo">
            <img src="./image/logo.png" alt="Logo El Rincón del Coleccionista">
        </div>
        <h1>Gestion de Empleados</h1>
    </header>
    <link rel="stylesheet" href="./css/empleados.css"> 
    <button onclick="window.location.href='homeEmpleados.php'">Volver</button>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Agregar Empleado</h1>
    <form action="" method="post">
        <label for="fecha_contratacion">Fecha de Contratación:</label>
        <input type="date" id="fecha_contratacion" name="fecha_contratacion" required><br><br>

        <label for="id_tipo_empleado_fk">Tipo de Empleado:</label>
        <select id="id_tipo_empleado_fk" name="id_tipo_empleado_fk" required>
            <?php
            foreach ($tiposEmpleados as $tipoEmpleado) {
                echo "<option value='" . $tipoEmpleado->getIdTipoEmpleadoPk() . "'>" . $tipoEmpleado->getDescripcion() . "</option>";
            }
            ?>
        </select><br><br>

        <label for="id_usuario_fk">ID Usuario:</label>
        <select id="id_usuario_fk" name="id_usuario_fk" required>
            <?php
            foreach ($usuarios as $usuario) {
                echo "<option value='" . $usuario->getIdUsuarioPk() . "'>" . $usuario->getNombreTienda() . " " . $usuario->getApellidoUsuario() . "</option>";
            }
            ?>
        </select><br><br>

        <label for="id_tienda_fk">ID Tienda:</label>
        <select id="id_tienda_fk" name="id_tienda_fk" required>
            <?php
            foreach ($tiendas as $tienda) {
                echo "<option value='" . $tienda->getIdTiendaPk() . "'>" . $tienda->getNombreTienda() . "</option>";
            }
            ?>
        </select><br><br>

        <input type="submit" value="Agregar Empleado">
    </form>

    <h2>Lista de Empleados</h2>
    <div id="tabla_empleados">
        <?php
        echo $empleados;
        ?>
    </div>
</body>
</html>
