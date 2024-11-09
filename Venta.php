<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if(!isset($_SESSION['user_id'])) {
  // Redirige a la página de inicio de sesión
  header("Location: login.php");
  exit();
}

// Si el usuario ha iniciado sesión, muestra el contenido protegido
echo "Bienvenido, " . $_SESSION['username'];
?>