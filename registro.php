<?php
require_once 'DAOUsuario.php';
require_once 'BD/usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST["username"];
    $correo = $_POST["email"];
    $contrasena = $_POST["password"];
    $confirmarContrasena = $_POST["confirm-password"];

    if ($contrasena !== $confirmarContrasena) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Hashear la contraseña antes de crear el usuario
        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
    
        // Imprimir el hash para depuración
        echo "Hash generado en registro: " . $hashedPassword . "<br>";
    
        $daoUsuario = new DAOUsuario();
        $usuario = new Usuario(null, $nombreUsuario, "", $correo, $hashedPassword);
    
        if ($daoUsuario->crearUsuario($usuario)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Tienda en Línea</title>
    <link rel="stylesheet" href="/Proyecto-LP3/css/registro.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <div class="overlay">
        <div class="register-box">
            <h2>Registro</h2>
            <form action="registro.php" method="POST" onsubmit="return validarContraseña()">
                <div class="input-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="confirm-password">Confirmar Contraseña</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <div class="input-group">
                    <button type="submit">Registrar</button>
                </div>
                <?php if (isset($error)): ?>
                    <div class="error-message">
                        <p><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>
                <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
            </form>
        </div>
    </div>
    <script>
        function validarContraseña() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;
            if (password != confirmPassword) {
                alert("Las contraseñas no coinciden.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
