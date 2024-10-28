<?php
require_once 'Usuario.php'; // Incluir la clase Usuario

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombreUsuario = $_POST["username"];
    $correo = $_POST["email"];
    $contrasena = $_POST["password"];
    $confirmarContrasena = $_POST["confirm-password"];

    // Validar que las contraseñas coincidan
    if ($contrasena !== $confirmarContrasena) {
        echo "Las contraseñas no coinciden.";
        exit(); // Detener la ejecución del script
    }

    // Validar que el usuario no exista (opcional, pero recomendado)
    try {
        $conn = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE nombreUsuario = :nombreUsuario");
        $stmt->bindParam(':nombreUsuario', $nombreUsuario);
        $stmt->execute();
        $usuarioExiste = $stmt->fetchColumn();

        if ($usuarioExiste > 0) {
            echo "El usuario ya existe.";
            exit(); // Detener la ejecución del script
        }
    } catch(PDOException $e) {
        echo "Error al verificar la existencia del usuario: " . $e->getMessage();
        exit();
    }


    // Crear una instancia de la clase Usuario
    $usuario = new Usuario($nombreUsuario, "", "", $correo, $contrasena); // Ajusta los valores según tu formulario

    // Registrar al usuario
    $usuario->registrarUsuario();

    // Redirigir al usuario a la página de login o a la página principal
    header("Location: ../front-end/login.html"); // O header("Location: ../front-end/index.php");
    exit(); // Detener la ejecución del script
}
?>