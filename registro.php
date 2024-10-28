<?php
require_once 'Usuario.php'; 
require_once 'Database.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST["username"];
    $correo = $_POST["email"];
    $contrasena = $_POST["password"];
    $confirmarContrasena = $_POST["confirm-password"];

    if ($contrasena !== $confirmarContrasena) {
        echo "Las contraseñas no coinciden.";
        exit(); 
    }

    $db = new Database(); // Crea una instancia de la clase Database

    // Validar que el usuario no exista (usando la clase Database)
    try {
        $conn = $db->getConexion(); 
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE nombreUsuario = :nombreUsuario");
        $stmt->bindParam(':nombreUsuario', $nombreUsuario);
        $stmt->execute();
        $usuarioExiste = $stmt->fetchColumn();

        if ($usuarioExiste > 0) {
            echo "El usuario ya existe.";
            exit(); 
        }
    } catch(PDOException $e) {
        echo "Error al verificar la existencia del usuario: " . $e->getMessage();
        exit();
    }

    $usuario = new Usuario($nombreUsuario, "", "", $correo, $contrasena); 

    if ($usuario->registrarUsuario($db)) { // Pasa el objeto $db al método
        header("Location: ../front-end/login.html"); 
        exit(); 
    } else {
        echo "Error al registrar el usuario.";
    }
}
?>