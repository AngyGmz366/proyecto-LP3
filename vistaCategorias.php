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
    <title>El Rincón del Coleccionista</title>
    <link rel="stylesheet" href="./css/categoriasVista.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="./image/logo.png" alt="Logo El Rincón del Coleccionista">
        </div>
        <h1>El Rincón del Coleccionista</h1>
        
        <nav>
            <!-- Selector dinámico de categorías -->
            <select id="filtroCategoria" onchange="filtrarPorCategoria()">
                <option value="todos">Todas las Categorías</option>
                <?php
                require_once 'DAO/DAOCategoria.php';

                $daoCategoria = new DAOCategoria();
                $categorias = $daoCategoria->obtenerTodasLasCategorias();

                if ($categorias) {
                    foreach ($categorias as $categoria) {
                        echo "<option value='" . strtolower($categoria->getNombreCategoria()) . "'>" . $categoria->getNombreCategoria() . "</option>";
                    }
                }
                ?>
            </select>
        </nav>
    </header>
    <button onclick="window.location.href='home.php'">Volver</button>
    <main>
        <div id="listaArticulos" class="contenedor-articulos">
            <?php
            require_once 'DAO/DAOArticulo.php';

            $daoArticulo = new DAOArticulo();
            $articulos = $daoArticulo->obtenerTodosLosArticulos();

            if ($articulos) {
                foreach ($articulos as $articulo) {
                    // Obtener categoría del artículo
                    $categoria = $daoCategoria->obtenerCategoriaPorId($articulo->getIdCategoriaFk());
                    $nombreCategoria = strtolower($categoria ? $categoria->getNombreCategoria() : "sin-categoria");

                    echo "<div class='card' data-categoria='" . $nombreCategoria . "'>";
                    echo "<div class='imagen-producto'>";

                    // Imagen del producto
                    $conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
                    $resultado = $conect->query("SELECT * FROM tbl_imagenes_articulos WHERE id_articulo_fk = " . $articulo->getIdArticuloPk());
                    if ($resultado->num_rows > 0) {
                        $imagen = $resultado->fetch_assoc();
                        echo "<img src='" . $imagen['url_imagen'] . "' alt='" . $articulo->getNombreArticulo() . "'>";
                    } else {
                        echo "<img src='/image/default.png' alt='Imagen no disponible'>";
                    }
                    $conect->close();

                    echo "</div>";
                    echo "<div class='contenido-producto'>";
                    echo "<h3>" . $articulo->getNombreArticulo() . "</h3>";
                    echo "<p>" . $articulo->getDescripcion() . "</p>";
                    echo "<p class='precio'>$" . number_format($articulo->getPrecioUnitario(), 2) . "</p>";
                    echo "<button class='btn-agregar' onclick='agregarAlCarrito(" . $articulo->getIdArticuloPk() . ")'>Agregar al carrito</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay artículos disponibles en este momento.</p>";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>© 2024 Tienda de Colección. Todos los derechos reservados.</p>
    </footer>
    <script>
        function filtrarPorCategoria() {
            const categoria = document.getElementById("filtroCategoria").value.toLowerCase();
            const tarjetas = document.querySelectorAll(".card");
            tarjetas.forEach((tarjeta) => {
                if (categoria === "todos" || tarjeta.dataset.categoria === categoria) {
                    tarjeta.style.display = "block";
                } else {
                    tarjeta.style.display = "none";
                }
            });
        }

        function agregarAlCarrito(idProducto) {
            alert('Producto ' + idProducto + ' agregado al carrito.');
            // Aquí puedes usar AJAX o redirigir a otra página para agregar el producto.
        }
    </script>
</body>
</html>
