<?php
require_once '../tienda/Usuario.php'; // Incluir la clase Usuario

session_start(); // Iniciar la sesión

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['codigoUsuario'])) {
    $usuario = new Usuario("", "", $_SESSION['codigoUsuario'], "", ""); 
    $nombreUsuario = $usuario->getNombreUsuario(); 
    
    // Mostrar contenido para usuarios logueados
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página principal</title>
        <link rel="stylesheet" href="estilos.css">  </head>
    <body>
        <div class="container"> 
            <h1>Bienvenido, <?php echo $nombreUsuario; ?>!</h1>
            <p>Este contenido es visible solo para usuarios que han iniciado sesión.</p>

            <a href="perfil.php">Ver mi perfil</a>
            <a href="../tienda/logout.php">Cerrar sesión</a> 
        </div>
    </body>
    </html>
    <?php
    
} else {
    // Mostrar enlace a login.html
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar sesión</title>
        <link rel="stylesheet" href="login.css">  </head>
    <body>
        <div class="container">
            <p>Para acceder a esta página, debes <a href="login.html">iniciar sesión</a>.</p> 
        </div>
    </body>
    </html>
    <?php
}
?>