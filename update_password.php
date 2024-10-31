<?php
require_once 'BD/informacion.php';

// Conectar a la base de datos
$conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
if ($conect->connect_error) {
    die("Conexión fallida: " . $conect->connect_error);
}

// Correo del usuario cuya contraseña queremos hashear
$correo = 'admin1@gmail.com';

// Nueva contraseña que queremos hashear y actualizar en la base de datos
$nueva_contrasena = password_hash('admin123', PASSWORD_DEFAULT);

$query = "UPDATE tbl_usuario SET contraseña='$nueva_contrasena' WHERE correo='$correo'";
if ($conect->query($query) === TRUE) {
    echo "Contraseña actualizada correctamente";
} else {
    echo "Error al actualizar la contraseña: " . $conect->error;
}

// Cerrar la conexión
$conect->close();
?>
