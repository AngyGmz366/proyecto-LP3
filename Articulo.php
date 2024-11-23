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
    <!-- Tabla de Artículos -->
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
                </tr>
            </thead>
            <tbody>
                <?php
                $daoArticulo = new DAOArticulo();
                $articulos = $daoArticulo->obtenerTodosLosArticulos();

                if ($articulos) {
                    foreach ($articulos as $a) {
                        echo "<tr>";
                        echo "<td>" . $a->getNombreArticulo() . "</td>";
                        echo "<td>" . $a->getIdArticuloPk() . "</td>";
                        echo "<td>" . $a->getDescripcion() . "</td>";
                        echo "<td>" . $a->getPrecioUnitario() . "</td>";
                        echo "<td>" . $a->getInventario() . "</td>";

                        // Obtener categoría
                        $daoCategoria = new DAOCategoria();
                        $categoria = $daoCategoria->obtenerCategoriaPorId($a->getIdCategoriaFk());
                        echo "<td>" . ($categoria ? $categoria->getNombreCategoria() : "N/D") . "</td>";

                        // Obtener imagen
                        $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
                        $resultado = $conect->query("SELECT * FROM tbl_imagenes_articulos WHERE id_articulo_fk = " . $a->getIdArticuloPk());
                        if ($resultado->num_rows > 0) {
                            $imagen = $resultado->fetch_assoc();
                            echo "<td><img src='" . $imagen['url_imagen'] . "' width='75' height='75'></td>";
                        } else {
                            echo "<td>N/D</td>";
                        }
                        $conect->close();

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay artículos disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <!-- Formulario para Agregar Nuevo Artículo -->
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
                echo '<input type="text" id="codigoArticulo" name="codigoArticulo" value="' . ($tupla['id_articulo_pk'] + 1) . '" readonly required>';
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
                $daoC = new DAOCategoria();
                $categorias = $daoC->obtenerTodasLasCategorias();
                foreach ($categorias as $categoria) {
                    echo '<option value="' . $categoria->getIdCategoriaPk() . '">' . $categoria->getNombreCategoria() . '</option>';
                }
                echo '</select>';
            ?>

            <label for="fotografiaArticulo">Fotografía:</label>
            <input type="file" id="fotografiaArticulo" name="fotografiaArticulo" accept="image/*" required>

            <button type="submit" name="bttAgregarArticulo">Agregar Artículo</button>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttAgregarArticulo'])) {
                $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);

                // Manejo de subida de archivo
                if (isset($_FILES['fotografiaArticulo']) && $_FILES['fotografiaArticulo']['error'] == 0) {
                    $archivo = $_FILES['fotografiaArticulo'];
                    $nombreArchivo = basename($archivo['name']);
                    $rutaDestino = './image/articulos/' . $nombreArchivo;

                    // Validar tipo de archivo
                    $tipoArchivo = strtolower(pathinfo($rutaDestino, PATHINFO_EXTENSION));
                    if (in_array($tipoArchivo, ['jpg', 'jpeg', 'png', 'gif'])) {
                        if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
                            $resultado = $conect->query("SELECT * FROM tbl_categoria WHERE id_categoria_pk = " . $_POST['slcCategorias'] . ";");
                            $tupla = $resultado->fetch_assoc();
                            $idCategoria = $tupla['id_categoria_pk'];

                            $articulo = new Articulo($_POST['codigoArticulo'], $_POST['nombreArticulo'], $_POST['descripcionArticulo'], $_POST['precio'], $_POST['cantidadExistencia'], $idCategoria);
                            $daoA = new DAOArticulo();
                            $daoA->crearArticulo($articulo);

                            $conect->query("INSERT INTO tbl_imagenes_articulos (url_imagen, id_articulo_fk) VALUES ('$rutaDestino', '" . $_POST['codigoArticulo'] . "');");
                            $conect->close();
                            header("Location: Articulo.php");
                            exit();
                        }
                    }
                }
            }
            ?>
        </form>
    </section>

    <!-- Formulario para Actualizar Artículo -->
    <section>
      <h2>Actualizar Artículo</h2>
       <form id="formActualizarArticulo" method="POST" action="" enctype="multipart/form-data">
         <label for="codigoArticulo">Seleccionar Id del Artículo:</label>
            <select id="codigoArticulo" name="codigoArticulo" required>
             <option value="">Seleccionar un artículo</option>
             <?php
                $daoArticulo = new DAOArticulo();
                $articulos = $daoArticulo->obtenerTodosLosArticulos();
               foreach ($articulos as $articulo) {
                 echo '<option value="' . $articulo->getIdArticuloPk() . '">' . $articulo->getIdArticuloPk() . ' - ' . $articulo->getNombreArticulo() . '</option>';
               }
             ?>
           </select>

         <label for="nombreArticulo">Nuevo Nombre:</label>
         <input type="text" id="nombreArticulo" name="nombreArticulo" required>

         <label for="descripcionArticulo">Nueva Descripción:</label>
         <input type="text" id="descripcionArticulo" name="descripcionArticulo" required>

         <label for="precioArticulo">Nuevo Precio:</label>
         <input type="number" id="precioArticulo" name="precioArticulo" required>
 
         <label for="cantidadArticulo">Nueva Cantidad:</label>
         <input type="number" id="cantidadArticulo" name="cantidadArticulo" required>

         <label for="categoriaArticulo">Nueva Categoría:</label>
           <select id="categoriaArticulo" name="categoriaArticulo" required>
             <option value="">Seleccionar una categoría</option>
             <?php
             $daoCategoria = new DAOCategoria();
             $categorias = $daoCategoria->obtenerTodasLasCategorias();
               foreach ($categorias as $categoria) {
                 echo '<option value="' . $categoria->getIdCategoriaPk() . '">' . $categoria->getNombreCategoria() . '</option>';
                }
               ?>
           </select>

         <label for="imagenArticulo">Nueva Imagen (opcional):</label>
         <input type="file" id="imagenArticulo" name="imagenArticulo" accept="image/*">

         <button type="submit" class="btn-actualizar" name="bttActualizarArticulo">Actualizar Artículo</button>
        </form>

        <?php
       if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttActualizarArticulo'])) {
         $idArticulo = intval($_POST['codigoArticulo']);
         $nombre = $_POST['nombreArticulo'];
         $descripcion = $_POST['descripcionArticulo'];
         $precio = $_POST['precioArticulo'];
         $cantidad = $_POST['cantidadArticulo'];
         $categoriaId = $_POST['categoriaArticulo'];

         $articulo = new Articulo($idArticulo, $nombre, $descripcion, $precio, $cantidad, $categoriaId);

         // Manejo de imagen
            if (isset($_FILES['imagenArticulo']) && $_FILES['imagenArticulo']['error'] == 0) {
             $archivo = $_FILES['imagenArticulo'];
             $nombreArchivo = basename($archivo['name']);
             $rutaDestino = './image/articulos/' . $nombreArchivo;

               if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
                 $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
                 $resultadoImagen = $conect->query("SELECT * FROM tbl_imagenes_articulos WHERE id_articulo_fk = $idArticulo");
                   if ($resultadoImagen->num_rows > 0) {
                     $conect->query("UPDATE tbl_imagenes_articulos SET url_imagen='$rutaDestino' WHERE id_articulo_fk=$idArticulo");
                    } else {
                     $conect->query("INSERT INTO tbl_imagenes_articulos (url_imagen, id_articulo_fk) VALUES ('$rutaDestino', $idArticulo)");
                    }
                     $conect->close();
                }
            }

           $daoArticulo->actualizarArticulo($articulo);
            header("Location: Articulo.php");
            exit();
        }
        ?>
    </section>
 

    <!-- Formulario para Eliminar Artículo -->
    <section>
     <h2>Eliminar Artículo</h2>
       <form id="formEliminarArticulo" method="POST" action="">
         <label for="idEliminarArticulo">Seleccionar Id del Artículo a Eliminar:</label>
         <select id="idEliminarArticulo" name="idEliminarArticulo" required>
             <option value="">Seleccionar un artículo</option>
             <?php
             $daoArticulo = new DAOArticulo();
             $articulos = $daoArticulo->obtenerTodosLosArticulos();
               foreach ($articulos as $articulo) {
                 echo '<option value="' . $articulo->getIdArticuloPk() . '">' . $articulo->getIdArticuloPk() . ' - ' . $articulo->getNombreArticulo() . '</option>';
               }
             ?>
           </select>

         <button type="submit" class="btn-eliminar" name="bttEliminarArticulo">Eliminar Artículo</button>
       </form>

     <?php
       if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttEliminarArticulo'])) {
         $idArticulo = intval($_POST['idEliminarArticulo']);
         $daoArticulo->eliminarArticulo($idArticulo);
         header("Location: Articulo.php");
         exit();
       }
     ?>
   </section>
</main>

<script src="./front-end/scripts/articulos.js"></script>
</body>
</html>
<?php 
ob_end_flush();
