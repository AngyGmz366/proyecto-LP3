<?php
require_once 'Usuario.php'; // Incluir la clase Usuario

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigoUsuario = $_POST["username"];
    $contrasena = $_POST["password"];

    $usuario = new Usuario("", "", $codigoUsuario, "", ""); 
    $usuario->login($codigoUsuario, $contrasena); 
}
?>