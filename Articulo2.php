<?php 
require_once 'BD/informacion.php'; 
require_once 'DAO/DAOArticulo.php'; 
require_once 'DAO/DAOCategoria.php';
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
    
    <form id="formVolver" method="POST" action="">
        <button type="submit" name="bttVolver">Volver</button>
    </form>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttVolver'])) {
            $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
            $conect->query("TRUNCATE TABLE tbl_temp_articulo");
            $conect->close();
            header("Location: Articulo.php");
            exit;
        }
    ?>
    
    <main>
        <section>      
            <h2>Editar artículo</h2>
            <?php
                $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
                $resultado = $conect->query("SELECT * FROM tbl_temp_articulo");
                $tupla = $resultado->fetch_assoc();
                $resultado = $conect->query("SELECT * FROM tbl_categoria WHERE id_categoria_pk = '".$tupla['id_categoria_fk']."';");
                $fk = $resultado->fetch_assoc();
                
                echo ''
                . '<form id="frmEditarArticulo" method="POST" action="">
                <label for="Código">Código:</label>
                <input type="text" id="codigoArticulo" name="codigoArticulo" value="'.$tupla['id_articulo_pk'].'" readonly required>
                
                <label for="Nombre">Nombre:</label>
                <input type="text" id="nombreArticulo" name="nombreArticulo" value="'.$tupla['nombre_articulo'].'" required>
                
                <label for="Descripción">Descripción:</label>
                <input type="text" id="descripcionArticulo" name="descripcionArticulo" value="'.$tupla['descripcion'].'" required>
                
                <label for="Precio">Precio:</label>
                <input type="number" id="precioArticulo" name="precioArticulo" value="'.$tupla['precio'].'" required>
                
                <label for="Inventario">Inventario:</label>
                <input type="number" id="inventarioArticulo" name="inventarioArticulo" value="'.$tupla['inventario'].'" required>
                
                <label for="Categoría">Categoría:</label>
                <select id="categoriaArticulo" name="categoriaArticulo" required><option value="'.$fk['nombre_categoria'].'">'.$fk['nombre_categoria'].'</option>';
                
                $c = new Categoria(null, "", "");
                $daoC = new DAOCategoria();
                $categorias = $daoC->obtenerTodasLasCategorias();
                foreach($categorias as $c) {
                    if ($c->getNombreCategoria() != $fk['nombre_categoria']) {
                        echo '<option value="'.$c->getNombreCategoria().'">'.$c->getNombreCategoria().'</option>';
                    }
                }
                echo '</select>
                <button type="submit" name="bttActualizarArticulo">Actualizar Artículo</button>
            </form>';
                
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bttActualizarArticulo'])) {
                    $resultado = $conect->query("SELECT * FROM tbl_categoria WHERE nombre_categoria = '".$_POST['categoriaArticulo']."';");
                    $tupla = $resultado->fetch_assoc();
                    $a = new Articulo($_POST['codigoArticulo'], $_POST['nombreArticulo'], $_POST['descripcionArticulo'],
                    $_POST['precioArticulo'], $_POST['inventarioArticulo'], $tupla['id_categoria_pk']);
                    $daoA = new DAOArticulo();
                    $daoA->actualizarArticulo($a);
                    $conect->query("TRUNCATE TABLE tbl_temp_articulo");
                    $conect->close();
                    header("Location: Articulo.php");
                    exit();
                }
            ?>
            
        </section>
    </main>
</body>