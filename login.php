<?php
require_once 'Usuario.php'; 
require_once 'Database.php'; // Asegúrate de incluir también la clase Database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigoUsuario = $_POST["username"];
    $contrasena = $_POST["password"];

    $db = new Database(); // Crea una instancia de la clase Database
    $usuario = new Usuario("", "", $codigoUsuario, "", ""); 
    
    if ($usuario->login($db, $codigoUsuario, $contrasena)) { 
        // Login exitoso, redirigir al usuario
        header("Location: ../front-end/index.php"); 
        exit();
    } else {
        echo "Código de usuario o contraseña incorrectos";
    }
}
?>