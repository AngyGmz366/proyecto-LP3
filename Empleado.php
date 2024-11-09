<?php 
require_once 'DAO/DAOEmpleado.php'; 
require_once 'BD/empleado.php';

// Crear una instancia del DAO
$daoEmpleado = new DAOEmpleado();

// Obtener los datos de los empleados
$empleados = $daoEmpleado->obtenerEmpleadosConDetalles(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link rel="stylesheet" href="./css/empleados.css"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
</head>

<body>

    <header>
        <div class="logo">
            <img src="./image/logo.png" alt="Logo de la Empresa">
        </div>
        <h1>Gestión de Empleados</h1>
    </header>
    <button onclick="window.location.href='homeEmpleados.php'">Volver</button>
    <br>

    <div class="container">

        <div class="form-container">
            <h2>Agregar Empleado</h2>
            <form id="agregarEmpleado" method="POST" action="">
                <label for="fecha_contratacion">Fecha de Contratación:</label>
                <input type="date" id="fecha_contratacion" name="fecha_contratacion" required>

                <label for="id_tipo_empleado_fk">Tipo de Empleado:</label>
                <select id="id_tipo_empleado_fk" name="id_tipo_empleado_fk" required>
                    <option value="1">Venta</option> 
                    <option value="2">Operario</option> 
                </select>

                <label for="id_usuario_fk">ID de Usuario:</label>
                <input type="number" id="id_usuario_fk" name="id_usuario_fk" required>

                <label for="id_tienda_fk">ID de Tienda:</label>
                <input type="number" id="id_tienda_fk" name="id_tienda_fk" required>

                <button type="submit" class="btn btn-primary" name="bttAgregarEmpleado">Agregar Empleado</button>
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttAgregarEmpleado'])) {
                    $e = new Empleado(null, $_POST['fecha_contratacion'], $_POST['id_tipo_empleado_fk'], $_POST['id_usuario_fk'], $_POST['id_tienda_fk']);
                    $daoE = new DAOEmpleado();
                    $daoE->crearEmpleado($e);
                    // Recargar la página después de agregar un empleado
                    echo "<script>window.location.href='Empleado.php';</script>"; 
                    exit();
                }
            ?>
        </div>

        <div class="form-container">
            <h2>Eliminar Empleado</h2>
            <form id="eliminarEmpleado" method="POST" action="">
                <label for="id_empleado_pk">ID del Empleado a Eliminar:</label>
                <input type="number" id="id_empleado_pk" name="id_empleado_pk" required>

                <button type="submit" class="btn btn-danger" name="bttEliminarEmpleado">Eliminar Empleado</button>
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttEliminarEmpleado'])) {
                    $id = $_POST['id_empleado_pk'];
                    $daoE = new DAOEmpleado();
                    $daoE->eliminarEmpleado($id);
                    // Recargar la página después de eliminar un empleado
                    echo "<script>window.location.href='Empleado.php';</script>"; 
                    exit();
                }
            ?>
        </div>

        <div class="form-container">
            <h2>Actualizar Empleado</h2>
            <form id="actualizarEmpleado" method="POST" action="">
                <label for="id_empleado_pk">ID del Empleado:</label>
                <input type="number" id="id_empleado_pk_actualizar" name="id_empleado_pk" readonly> 

                <label for="fecha_contratacion">Nueva Fecha de Contratación:</label>
                <input type="date" id="fecha_contratacion_actualizar" name="fecha_contratacion" required>

                <label for="id_tipo_empleado_fk">Nuevo Tipo de Empleado:</label>
                <select id="id_tipo_empleado_fk_actualizar" name="id_tipo_empleado_fk" required>
                    <option value="1">Venta</option> 
                    <option value="2">Operario</option> 
                </select>

                <label for="id_usuario_fk">Nuevo ID de Usuario:</label>
                <input type="number" id="id_usuario_fk_actualizar" name="id_usuario_fk" required>

                <label for="id_tienda_fk">Nuevo ID de Tienda:</label>
                <input type="number" id="id_tienda_fk_actualizar" name="id_tienda_fk" required>

                <button type="submit" class="btn btn-warning" name="bttActualizarEmpleado">Actualizar Empleado</button>
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttActualizarEmpleado'])) {
                    $e = new Empleado($_POST['id_empleado_pk'], $_POST['fecha_contratacion'], $_POST['id_tipo_empleado_fk'], $_POST['id_usuario_fk'], $_POST['id_tienda_fk']);
                    $daoE = new DAOEmpleado();
                    $daoE->actualizarEmpleado($e);
                    // Recargar la página después de actualizar un empleado
                    echo "<script>window.location.href='Empleado.php';</script>"; 
                    exit();
                }
            ?>
        </div>

        <div class="table-container">  
            <table class='table table-dark'>
                <thead class='thead thead-light'>
                    <tr>
                        <th>ID Empleado</th>
                        <th>Fecha de Contratación</th>
                        <th>Tipo de Empleado</th>
                        <th>Tienda</th>
                        <th>ID Usuario</th>
                        <th>Nombre de Usuario</th>
                        <th>Correo</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $empleado): ?>
                        <tr>
                            <td><?php echo $empleado['id_empleado_pk']; ?></td>
                            <td><?php echo $empleado['fecha_contratacion']; ?></td>
                            <td><?php echo $empleado['tipo_empleado']; ?></td>
                            <td><?php echo $empleado['tienda']; ?></td>
                            <td><?php echo $empleado['id_usuario_pk']; ?></td>
                            <td><?php echo $empleado['nombre_usuario']; ?></td>
                            <td><?php echo $empleado['correo']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>