<?php
require_once 'DAO/DAOCarrito.php';
require_once 'DAO/DAODetalleCarrito.php';

try {
    $daoCarrito = new DAOCarrito();
    $daoDetalleCarrito = new DAODetalleCarrito();

    // Obtener el carrito actual
    $carrito = $daoCarrito->obtenerCarritoActual();
    if ($carrito) {
        $idCarrito = $carrito->getIdCarritoPk();

        // Llamar al método para vaciar el carrito
        $daoDetalleCarrito->vaciarCarrito($idCarrito);

        // Mostrar alerta de éxito con SweetAlert2
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Carrito Vaciado</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    title: 'Carrito vaciado',
                    text: 'Todos los productos fueron eliminados del carrito.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'VistaCarrito.php';
                    }
                });
            </script>
        </body>
        </html>
        ";
    } else {
        // Mostrar alerta si no hay carrito
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Carrito Inexistente</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    title: 'Carrito vacío',
                    text: 'No hay un carrito activo para vaciar.',
                    icon: 'info',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'VistaCarrito.php';
                    }
                });
            </script>
        </body>
        </html>
        ";
    }
} catch (Exception $e) {
    // Mostrar alerta de error con SweetAlert2
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Error</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error al vaciar el carrito: " . addslashes($e->getMessage()) . "',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'VistaCarrito.php';
                }
            });
        </script>
    </body>
    </html>
    ";
}
?>
