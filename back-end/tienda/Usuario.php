<?php
require_once 'Persona.php';

class Usuario extends Persona {
    private $codigoUsuario;
    private $correo;
    private $contrasena;
    private $fechaRegistro;

    public function __construct($nombre, $apellido, $codigoUsuario, $correo, $contrasena) {
        parent::__construct($nombre, $apellido);
        $this->codigoUsuario = $codigoUsuario;
        $this->correo = $correo;
        $this->contrasena = password_hash($contrasena, PASSWORD_DEFAULT); // Encriptar la contraseña
        $this->fechaRegistro = new DateTime(); 
    }

    // Getters
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
        // Lógica para registrar un nuevo usuario en la base de datos
        // Ejemplo con PDO:
        try {
            $conn = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, codigoUsuario, correo, contrasena) 
            VALUES (:nombre, :apellido, :codigoUsuario, :correo, :contrasena)");
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellido', $this->apellido);
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
        // Lógica para eliminar un usuario de la base de datos
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
        // Lógica para iniciar sesión
        try {
            $conn = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE codigoUsuario = :codigoUsuario");
            $stmt->bindParam(':codigoUsuario', $codigoUsuario);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                // Inicio de sesión exitoso
                echo "Inicio de sesión exitoso";
                // ... iniciar sesión (ej. con variables de sesión)
            } else {
                // Credenciales incorrectas
                echo "Codigo de usuario o contraseña incorrectos";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function contrasenaCorrecta($contrasena) { 
        // Lógica para verificar si la contraseña es correcta (usar password_verify)
        return password_verify($contrasena, $this->contrasena);
    }

    public function actualizarPerfil() { 
        // Lógica para actualizar el perfil del usuario en la base de datos
        // ...
    }
}

?>