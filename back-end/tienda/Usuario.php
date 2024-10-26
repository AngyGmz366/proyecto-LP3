<?php

class Usuario {
    private $nombreUsuario;
    private $apellidoUsuario;
    private $codigoUsuario;
    private $correo;
    private $contrasena;
    private $fechaRegistro;

    public function __construct($nombreUsuario, $apellidoUsuario, $codigoUsuario, $correo, $contrasena) {
        $this->nombreUsuario = $nombreUsuario;
        $this->apellidoUsuario = $apellidoUsuario;
        $this->codigoUsuario = $codigoUsuario;
        $this->correo = $correo;
        $this->contrasena = password_hash($contrasena, PASSWORD_DEFAULT); // Encriptar la contraseña
        $this->fechaRegistro = new DateTime(); 
    }

    // Getters
    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function getApellidoUsuario() {
        return $this->apellidoUsuario;
    }

    public function getCodigoUsuario() {
        return $this->codigoUsuario;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    // Setters
    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setApellidoUsuario($apellidoUsuario) {
        $this->apellidoUsuario = $apellidoUsuario;
    }

    public function setCodigoUsuario($codigoUsuario) {
        $this->codigoUsuario = $codigoUsuario;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = password_hash($contrasena, PASSWORD_DEFAULT); // Encriptar la contraseña
    }

    // Métodos 
    public function registrarUsuario() { 
        try {
            $conn = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("INSERT INTO usuarios (nombreUsuario, apellidoUsuario, codigoUsuario, correo, contrasena) 
            VALUES (:nombreUsuario, :apellidoUsuario, :codigoUsuario, :correo, :contrasena)");
            $stmt->bindParam(':nombreUsuario', $this->nombreUsuario);
            $stmt->bindParam(':apellidoUsuario', $this->apellidoUsuario);
            $stmt->bindParam(':codigoUsuario', $this->codigoUsuario);
            $stmt->bindParam(':correo', $this->correo);
            $stmt->bindParam(':contrasena', $this->contrasena);
            $stmt->execute();
            echo "Nuevo usuario creado exitosamente";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function eliminarUsuario($codigoUsuario) { 
        try {
            $conn = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("DELETE FROM usuarios WHERE codigoUsuario = :codigoUsuario");
            $stmt->bindParam(':codigoUsuario', $codigoUsuario);
            $stmt->execute();
            echo "Usuario eliminado exitosamente";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function recuperarCuenta($codigoUsuario) { 
        // Lógica para recuperar la cuenta de un usuario (ej. enviar correo electrónico)
        // ...
    }

    public function login($codigoUsuario, $contrasena) { 
        try {
            $conn = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE codigoUsuario = :codigoUsuario");
            $stmt->bindParam(':codigoUsuario', $codigoUsuario);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                echo "Inicio de sesión exitoso";
                // ... iniciar sesión (ej. con variables de sesión)
            } else {
                echo "Codigo de usuario o contraseña incorrectos";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function contrasenaCorrecta($contrasena) { 
        return password_verify($contrasena, $this->contrasena);
    }

    public function actualizarPerfil() { 
        // Lógica para actualizar el perfil del usuario en la base de datos
        // ...
    }
}

?>