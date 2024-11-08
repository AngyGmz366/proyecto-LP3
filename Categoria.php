<?php 
require_once 'DAO/DAOCategoria.php'; 
require_once 'BD/categoria.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Categorías - Rincon del Coleccionista</title>
    <link rel="stylesheet" href="./css/categorias.css">
</head>

<body>

    <header>
        <div class="logo">
            <img src="./image/logo.png" alt="Logo El Rincón del Coleccionista">
        </div>
        <h1>Gestion de Categorías</h1>
    </header>
    <button onclick="window.location.href='homeEmpleados.php'">Volver</button>
    <br>

    <div class="container">

        <!-- Formulario para Agregar una Categoría -->
        <div class="form-container">
            <h2>Agregar Categoría</h2>
            <form id="agregarCategoria" method="POST" action="">
                <label for="idCategoria">Id:</label>
                <?php
                    $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
                    $resultado = $conect->query("SELECT * FROM tbl_categoria ORDER BY id_categoria_pk DESC LIMIT 1;");
                    $tupla = $resultado->fetch_assoc();
                    echo '<input type="text" id="idCategoria" name="idCategoria" value="'.$tupla['id_categoria_pk']+(1).'" disabled="true" required>';
                    echo '';
                ?>

                <label for="nombreCategoria">Nombre:</label>
                <input type="text" id="nombreCategoria" name="nombreCategoria" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcionCategoria" name="descripcionCategoria" required></textarea>

                <button type="submit" class="btn-agregar" name="bttAgregarCategoria">Agregar Categoría</button>
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttAgregarCategoria'])) {
                    $c = new Categoria(null, $_POST['nombreCategoria'], $_POST['descripcionCategoria']);
                    $cc = new DAOCategoria();
                    $cc->crearCategoria($c);
                    header("Location: #categoria.php");
                    exit();
                }
            ?>
        </div>

        <!-- Formulario para Eliminar una Categoría -->
        <div class="form-container">
            <h2>Eliminar Categoría</h2>
            <form id="eliminarCategoria" method="POST" action="">
                <label for="idEliminar">Id de la Categoría a Eliminar:</label>
                <input type="text" id="idCategoria" name="idCategoria" required>

                <button type="submit" class="btn-eliminar" name="bttEliminarCategoria">Eliminar Categoría</button>
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttEliminarCategoria'])) {
                    $id = $_POST['idCategoria'];
                    $cc = new DAOCategoria();
                    $cc->eliminarCategoria($id);
                    header("Location: #categoria.php");
                    exit();
                }
            ?>
        </div>

        <!-- Formulario para Actualizar una Categoría -->
        <div class="form-container">
            <h2>Actualizar Categoría</h2>
            <form id="actualizarCategoria" method="POST" action="">
                <label for="idActualizar">Id:</label>
                <input type="text" id="idActualizar" name="idActualizar" required>

                <label for="nombreActualizar">Nuevo Nombre:</label>
                <input type="text" id="nombreActualizar" name="nombreActualizar" required>

                <label for="descripcionActualizar">Nueva Descripción:</label>
                <textarea id="descripcionActualizar" name="descripcionActualizar" required></textarea>

                <button type="submit" class="btn-actualizar" name="bttActualizarCategoria">Actualizar Categoría</button>
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttActualizarCategoria'])) {
                    $c = new Categoria($_POST['idActualizar'], $_POST['nombreActualizar'], $_POST['descripcionActualizar']);
                    $cc = new DAOCategoria();
                    $cc->actualizarCategoria($c);
                    header("Location: #categoria.php");
                    exit();
                }
            ?>
        </div>

        <!-- Tabla de Categorías -->
        <h2>Lista de Categorías</h2>
        <table id="tablaCategorias">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <!-- Filas dinámicas serán agregadas aquí -->
                    <?php
                        $c = new Categoria(999, "", "");
                        $daoC = new DAOCategoria();
                        $categorias = $daoC->obtenerTodasLasCategorias();
                        if ($categorias > 0) {
                            foreach($categorias as $c) {
                            echo "<tr>";
                            echo "<th>".$c->getIdCategoriaPk()."</th>";
                            echo "<th>".$c->getNombreCategoria()."</th>";
                            echo "<th>".$c->getDescripcion()."</th>";
                            echo "</tr>";
                            }
                        }
                    ?>
            </tbody>
        </table>
    </div>

    <script src="./front-end/scripts/categorias.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>

