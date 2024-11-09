<?php 
require_once 'DAO/DAOCategoria.php'; 
require_once 'BD/articulo.php'; 
require_once 'DAO/DAOArticulo.php';
require_once 'BD/informacion.php';   
 ob_start();
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
    
    <!-- Input oculto que almacena el índice del elemento seleccionado para actualizar o eliminar -->
    <form id="formOculto" name="formOculto" method="POST" action="">
        <input type="text" id="idOculto" name="idOculto" readonly>
        <input type="text" id="inputOculto" name="inputOculto" readonly>
        <button type="submit" name="bttOculto" id="bttOculto">Enviar</button>
        <script>
            document.getElementById("formOculto").style.display = "none";
        </script>
        <?php
            $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttOculto'])) {
                if (isset($_POST['idOculto']) && $_POST['inputOculto'] != "") {
                    $conect->query("DELETE FROM tbl_articulo WHERE id_articulo_pk = ".$_POST['idOculto'].";");
                    header("Location: Articulo.php");
                    exit;
                }
                else {
                    $res = $conect->query("SELECT * FROM tbl_articulo WHERE id_articulo_pk = '".$_POST['idOculto']."';");
                    $copia = $res->fetch_assoc();
                    $conect->query("INSERT INTO tbl_temp_articulo(id_articulo_pk, nombre_articulo, descripcion, precio, inventario, id_categoria_fk) "
                            . "VALUES ('".$copia['id_articulo_pk']."', '".$copia['nombre_articulo']."', '".$copia['descripcion']."', '".$copia['precio_unitario']."', '"
                            . $copia['inventario']."', '".$copia['id_categoria_fk']."');");
                    $conect->close();
                    header("Location: Articulo2.php");
                    exit();
                }
            }
        ?>
    </form>
    
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
                <tbody><?php echo '
                    <script>function retornarIndice(enlace, s) {
                        var indice = enlace.closest("tr").parentNode.closest("tr");
                        var id = indice.cells[1].innerText;
                        document.getElementById("idOculto").value = id;
                        document.getElementById("inputOculto").value = s;
                        document.getElementById("bttOculto").click();
                    }</script>';?>
                    <!-- Filas generadas dinámicamente -->
                    <?php
                        $a = new Articulo(999, "", "", 999, 0, 0);
                        $daoA = new DAOArticulo();
                        $articulos = $daoA->obtenerTodosLosArticulos();
                        $indice = 0;
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
                                echo "<th>";
                                $resultado = $conect->query("SELECT * FROM tbl_imagenes_articulos WHERE id_articulo_fk = ".$a->getIdArticuloPk().";");
                                if ($resultado->num_rows > 0) {
                                    $tupla = $resultado->fetch_assoc();
                                    echo '<img src="'.$tupla['url_imagen'].'" width="75" height="75">';
                                }
                                else {
                                    echo '<h3>N/D</h3>';
                                }
                                echo "</th>";
                                echo '<th><table><tr><th><a href="#" onclick="retornarIndice(this, null);">Actualizar</a></th></tr><tr><th><a href="#" onclick="retornarIndice(this, 1);">Eliminar</a></th></tr></table></th>';
                                echo "</tr>";
                                $conect->close();
                            }
                        }
                    ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Agregar Nuevo Artículo</h2>
            <form id="formArticulo" method="POST" action="" enctype="multipart/form-data">
                <label for="nombreArticulo">Nombre:</label>
                <input type="text" id="nombreArticulo" name="nombreArticulo" required>

                <label for="codigoArticulo">Código:</label>
                <?php
                    $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
                    $resultado = $conect->query("SELECT * from tbl_articulo ORDER BY id_articulo_pk DESC LIMIT 1;");
                    $tupla = $resultado->fetch_assoc();
                    echo '<input type="text" id="codigoArticulo" name="codigoArticulo" value="'.$tupla['id_articulo_pk']+(1).'" readonly required>';
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
                
                <script>
                    function obtenerRuta(archivo) {
                        var nombre = archivo.files[0].name;
                        var ruta = "./image/articulos"+nombre;
                        document.getElementById("preview").src = ruta;
                        document.getElementById("rutaFoto").value = ruta;
                    }
                </script>
                <label for="fotografiaArticulo">Fotografía:</label>
                <input type="file" id="fotografiaArticulo" name="fotografiaArticulo" accept="image/*" onchange="obtenerRuta(this);" required>
                <img id="preview" src="" style="display: none; margin-top: 10px;">
                <input type="text" id="rutaFoto" name="rutaFoto" readonly>
                <script>document.getElementById("rutaFoto").style.display = "none";</script>
                
                <button type="submit" name="bttAgregarArticulo">Agregar Artículo</button>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttAgregarArticulo'])) {
                        $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
                        $resultado = $conect->query("SELECT * FROM tbl_categoria WHERE nombre_categoria = '".$_POST['slcCategorias']."';");
                        $tupla = $resultado->fetch_assoc();
                        $a = new Articulo($_POST['codigoArticulo'], $_POST['nombreArticulo'], $_POST['descripcionArticulo'],
                        $_POST['precio'], $_POST['cantidadExistencia'], $tupla['id_categoria_pk']);
                        $conect->query("INSERT INTO tbl_imagenes_articulos (url_imagen, id_articulo_fk) VALUES ('".$_POST['rutaFoto']."', ".$_POST['codigoArticulo'].");");
                        $conect->close();
                        $daoA = new DAOArticulo();
                        $daoA->crearArticulo($a);
                        header("Location: Articulo.php");
                        exit();
                    }
                ?>
            </form>
        </section>
    </main>

    <script src="./front-end/scripts/articulos.js"></script>
</body>
</html>

<?php
    ob_end_flush();