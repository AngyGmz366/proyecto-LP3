<?php
require_once 'DAO/DAODetalleCarrito.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $idDetalle = intval($_GET['id']);
    try {
        $daoDetalleCarrito = new DAODetalleCarrito();
        $resultado = $daoDetalleCarrito->eliminarDetalleCarrito($idDetalle);

        // Mostrar alerta de éxito o error con SweetAlert2
        if ($resultado) {
            echo "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Redirigiendo...</title>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        title: 'Producto eliminado',
                        text: 'El producto fue eliminado del carrito exitosamente.',
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
                        text: 'No se pudo eliminar el producto del carrito.',
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
                    text: 'Ocurrió un error al eliminar el producto: " . addslashes($e->getMessage()) . "',
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
} else {
    // Si no se recibió un ID válido, mostrar una alerta de error
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
                title: 'ID inválido',
                text: 'No se recibió un ID válido para eliminar el producto.',
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
