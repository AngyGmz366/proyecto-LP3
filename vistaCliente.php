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
    <title>Tienda</title>
    <link rel="stylesheet" href="./css/VistaClientes.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="./image/logo.png" alt="Logo">
    </div>
    <h1>¡Compra nuestros productos!</h1>
   
</header>
<button onclick="window.location.href='home.php'">Volver</button>

<main>
    <section class="productos">
        <?php
        require_once 'DAO/DAOArticulo.php';
        $daoArticulo = new DAOArticulo();
        $articulos = $daoArticulo->obtenerTodosLosArticulos();

        if ($articulos) {
            foreach ($articulos as $a) {
                echo '<div class="card">';
                echo '<div class="imagen-producto">';
                
                // Obtener imagen del producto
                $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
                $resultado = $conect->query("SELECT * FROM tbl_imagenes_articulos WHERE id_articulo_fk = " . $a->getIdArticuloPk());
                if ($resultado->num_rows > 0) {
                    $imagen = $resultado->fetch_assoc();
                    echo "<img src='" . $imagen['url_imagen'] . "' alt='" . $a->getNombreArticulo() . "'>";
                } else {
                    echo "<img src='./image/default.png' alt='Imagen no disponible'>";
                }
                $conect->close();

                echo '</div>';
                echo '<div class="contenido-producto">';
                echo '<h3>' . $a->getNombreArticulo() . '</h3>';
                echo '<p>' . $a->getDescripcion() . '</p>';
                echo '<p class="precio">$' . number_format($a->getPrecioUnitario(), 2) . '</p>';
                // Botón para agregar al carrito
                echo "<form method='POST' action='Carrito.php'>";
                echo "<input type='hidden' name='id_articulo' value='" . $a->getIdArticuloPk() . "'>";
                echo "<input type='hidden' name='cantidad' value='1'>";
                echo "<button type='submit' class='btn-agregar'>Agregar al carrito</button>";
                echo "</form>";
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No hay artículos disponibles.</p>';
        }
        ?>
    </section>
</main>
   <footer>
        <p>© 2024 Tienda de Colección. Todos los derechos reservados.</p>
    </footer>

<script>
  function agregarAlCarrito(idProducto) {
        fetch('agregarCarrito.php', {
         method: 'POST',
            headers: {
             'Content-Type': 'application/json',
            },
         body: JSON.stringify({ idProducto: idProducto, cantidad: 1 }), // Cantidad predeterminada: 1
       })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert('Producto agregado al carrito con éxito.');
                // Opcional: Actualizar la vista del carrito
            } else {
                alert(data.message || 'Error al agregar el producto al carrito.');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Hubo un problema al agregar el producto al carrito.');
        });
   }
 
    
</script>
</body>
</html>
