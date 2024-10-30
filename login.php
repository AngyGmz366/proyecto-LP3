<?php
require_once 'DAOUsuario.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $daoUsuario = new DAOUsuario();
    $usuario = $daoUsuario->verificarCredenciales($correo, $contrasena);

    if ($usuario) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['mensaje_bienvenida'] = "Bienvenido, " . $usuario->getNombreTienda() . "!";
        header('Location: index.php');
        exit();
    } else {
        $error = "Correo o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tienda en Línea</title>
    <link rel="stylesheet" href="/Proyecto-LP3/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <div class="overlay">
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" required>
                </div>
                <div class="input-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                </div>
                <div class="input-group">
                    <button type="submit">Ingresar</button>
                </div>
                <?php if (isset($error)): ?>
                    <div class="error-message">
                        <p><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>
                <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
            </form>
        </div>
    </div>
</body>
</html>

