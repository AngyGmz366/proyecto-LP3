<?php 
require_once 'DAO/DAOCategoria.php'; 
require_once 'BD/articulo.php';
require_once 'DAO/DAOArticulo.php';
require_once 'BD/informacion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Artículos</title>
    <link rel="stylesheet" href="./css/articulos.css">
</head>

<body>

    <header>
        <div class="logo">
            <img src="./image/logo.png" alt="Logo El Rincón del Coleccionista">
        </div>
        
        <h1>Gestión de Artículos</h1>
    </header>
    <button onclick="window.location.href='homeEmpleados.php'">Volver</button>
    <main>
        <section>
            <h2>Lista de Artículos</h2>
            <table id="tablaArticulos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Filas generadas dinámicamente -->
                    <?php
                        $a = new Articulo(999, "", "", 999, 0, 0);
                        $daoA = new DAOArticulo();
                        $articulos = $daoA->obtenerTodosLosArticulos();
                        if ($articulos > 0) {
                            foreach($articulos as $a) {
                            echo "<tr>";
                            echo "<th>".$a->getNombreArticulo()."</th>";
                            echo "<th>".$a->getIdArticuloPk()."</th>";
                            echo "<th>".$a->getDescripcion()."</th>";
                            echo "<th>".$a->getPrecioUnitario()."</th>";
                            echo "<th>".$a->getInventario()."</th>";
                            $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
                            $resultado = $conect->query("SELECT * FROM tbl_categoria WHERE id_categoria_pk = '".$a->getIdCategoriaFk()."';");
                            $tupla = $resultado->fetch_assoc();
                            echo "<th>".$tupla['nombre_categoria']."</th>";
                            $conect->close();
                            echo "<th>Pendiente :p</th>";
                            echo "<th>Pendiente :p</th>";
                            echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Agregar Nuevo Artículo</h2>
            <form id="formArticulo" method="POST" action="">
                <label for="nombreArticulo">Nombre:</label>
                <input type="text" id="nombreArticulo" name="nombreArticulo" required>

                <label for="codigoArticulo">Código:</label>
                <?php
                    $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
                    $resultado = $conect->query("SELECT * from tbl_articulo ORDER BY id_articulo_pk DESC LIMIT 1;");
                    $tupla = $resultado->fetch_assoc();
                    echo '<input type="text" id="codigoArticulo" name="codigoArticulo" value="'.$tupla['id_articulo_pk']+(1).'" disabled="true" required>';
                ?>
                
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcionArticulo" name="descripcionArticulo" required>

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" required>

                <label for="cantidadExistencia">Cantidad:</label>
                <input type="number" id="cantidadExistencia" name="cantidadExistencia" required>

                <label for="categoria">Categoría:</label>
                <?php
                    echo '<select id="slcCategorias" name="slcCategorias" required><option value="">Seleccionar una categoría</option>';
                    $c = new Categoria(null, "", "");
                    $daoC = new DAOCategoria();
                    $categorias = $daoC->obtenerTodasLasCategorias();
                    foreach($categorias as $c) {
                        echo '<option value="'.$c->getNombreCategoria().'">'.$c->getNombreCategoria().'</option>';
                    }
                    echo '</select>';
                ?>

                <label for="fotografiaArticulo">Fotografía:</label>
                <input type="file" id="fotografiaArticulo" accept="image/*" required>
                <img id="preview" style="display: none; margin-top: 10px;">

                <button type="submit" name="bttAgregarArticulo">Agregar Artículo</button>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttAgregarArticulo'])) {
                        $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
                        $resultado = $conect->query("SELECT * FROM tbl_categoria WHERE nombre_categoria = '".$_POST['slcCategorias']."';");
                        $tupla = $resultado->fetch_assoc();
                        $a = new Articulo($_POST['codigoArticulo'], $_POST['nombreArticulo'], $_POST['descripcionArticulo'],
                        $_POST['precio'], $_POST['cantidadExistencia'], $tupla['id_categoria_pk']);
                        $conect->close();
                        $daoA = new DAOArticulo();
                        $daoA->crearArticulo($a);
                        header("Location: #articulo.php");
                        exit();
                    }
                ?>
            </form>
        </section>
    </main>

    <script src="./front-end/scripts/articulos.js"></script>
</body>
</html>
