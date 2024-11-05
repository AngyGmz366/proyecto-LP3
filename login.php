<?php
require_once 'DAOUsuario.php';
require_once 'BD/usuario.php';
session_start();

header('Content-Type: application/json'); // Indica que la respuesta es JSON

$response = []; // Array para guardar la respuesta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

    if (empty($correo) || empty($contrasena)) {
        $response['success'] = false;
        $response['message'] = "Por favor, complete todos los campos.";
    } else {
        $daoUsuario = new DAOUsuario();
        $usuario = $daoUsuario->verificarCredenciales($correo, $contrasena);

        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['mensaje_bienvenida'] = "Bienvenido, " . $usuario->getNombreTienda() . "!";

            $response['success'] = true;
            $response['redirect'] = ($correo === 'admin1@u') ? 'homeEmpleados.php' : 'home.php';
        } else {
            $response['success'] = false;
            $response['message'] = "Correo o contraseña incorrectos";
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = "Método de solicitud no permitido";
}

echo json_encode($response);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - El rincón del coleccionista</title>
    <link rel="stylesheet" href="./css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="header-title">El rincón del coleccionista</h1> 
        </div>
    </header>
    <div class="overlay">
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            <form id="loginForm" action="login.php" method="POST" onsubmit="return handleSubmit(event)">
                <div class="input-group">
                    <label for="correo">Correo electrónico</label>
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

    <script>
        async function handleSubmit(event) {
    event.preventDefault(); // Evita que el formulario se envíe de inmediato

    const correo = document.getElementById('correo').value;
    const contrasena = document.getElementById('contrasena').value;

    if (correo === '' || contrasena === '') {
        Swal.fire('Error', 'Por favor, complete todos los campos.', 'error');
        return;
    }

    // Enviar datos al servidor con fetch
    const response = await fetch('login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ correo, contrasena })
    });

    const result = await response.json();

    // Mostrar alerta dependiendo de la respuesta del servidor
    if (result.success) {
        Swal.fire({
            title: 'Sesión iniciada con éxito',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = result.redirect; // Redirige a la página correspondiente
        });
    } else {
        Swal.fire('Error', result.message, 'error');
    }
}

    </script>
</body>
</html>

