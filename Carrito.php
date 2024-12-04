<?php
require_once 'DAO/DAOCarrito.php';
require_once 'DAO/DAODetalleCarrito.php';
require_once 'BD/informacion.php'; // Si contiene configuraciones necesarias
require_once 'DAO/DAOArticulo.php'; // Para validar o trabajar con artículos
session_start();

$idArticulo = intval($_POST['id_articulo']);
$cantidad = intval($_POST['cantidad']);

try {
    $daoCarrito = new DAOCarrito();
    $daoDetalleCarrito = new DAODetalleCarrito();
    $daoArticulo = new DAOArticulo();

    // Validar que el artículo exista
    $articulo = $daoArticulo->obtenerArticuloPorId($idArticulo);
    if (!$articulo) {
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    title: 'Error',
                    text: 'El artículo no existe.',
                    icon: 'error',
                    confirmButtonText: 'Volver'
                }).then(() => {
                    window.history.back();
                });
            </script>
        </body>
        </html>
        ";
        exit;
    }

    // Verificar si existe un carrito para el cliente
    $carrito = $daoCarrito->obtenerCarritoActual();
    if (!$carrito) {
        // Crear un nuevo carrito si no existe
        $nuevoCarritoCreado = $daoCarrito->crearCarrito();
        if ($nuevoCarritoCreado) {
            // Obtener el carrito recién creado
            $carrito = $daoCarrito->obtenerCarritoActual();
        } else {
            throw new Exception("Error al crear el carrito.");
        }
    }

    $idCarrito = $carrito->getIdCarritoPk();

    // Verificar si el artículo ya está en el carrito
    $detalleExistente = $daoDetalleCarrito->obtenerDetallePorArticuloYCarrito($idCarrito, $idArticulo);
    if ($detalleExistente) {
        // Si el artículo ya está en el carrito, actualizar la cantidad
        $nuevaCantidad = $detalleExistente->getCantidad() + $cantidad;
        $detalleExistente->setCantidad($nuevaCantidad);
        $daoDetalleCarrito->actualizarDetalleCarrito($detalleExistente);
    } else {
        // Si el artículo no está en el carrito, agregarlo
        $detalleCarrito = new DetalleCarrito(null, $cantidad, $idArticulo, $idCarrito);
        $daoDetalleCarrito->crearDetalleCarrito($detalleCarrito);
    }

    // Notificación de éxito usando SweetAlert2
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Artículo agregado',
                text: 'El artículo se agregó exitosamente al carrito.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = 'vistaCategorias.php';
            });
        </script>
    </body>
    </html>
    ";
} catch (Exception $e) {
    // Manejo de errores usando SweetAlert2
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Error',
                text: 'Error al agregar artículo al carrito: " . addslashes($e->getMessage()) . "',
                icon: 'error',
                confirmButtonText: 'Volver'
            }).then(() => {
                window.history.back();
            });
        </script>
    </body>
    </html>
    ";
}
?>
