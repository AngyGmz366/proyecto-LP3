<?php

class Database {
    private $host = "localhost";
    private $usuario = "root";
    private $contraseña = "";
    private $nombre_base_datos = "tiendaonline";
    private $conexion;

    public function __construct() {
        $this->conectar();
    }

    private function conectar() {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->contraseña, $this->nombre_base_datos);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function getConexion() {
        return $this->conexion;
    }

    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }

    public function __destruct() {
        $this->cerrarConexion();
    }
}

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
        $this->contrasena = password_hash($contrasena, PASSWORD_DEFAULT); 
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
        $this->contrasena = password_hash($contrasena, PASSWORD_DEFAULT); 
    }

    // Métodos
    public function registrarUsuario(Database $db) {  
        try {
            $conn = $db->getConexion(); 
            $stmt = $conn->prepare("INSERT INTO usuarios (nombreUsuario, apellidoUsuario, codigoUsuario, correo, contrasena) 
            VALUES (:nombreUsuario, :apellidoUsuario, :codigoUsuario, :correo, :contrasena)");
            $stmt->bindParam(':nombreUsuario', $this->nombreUsuario);
            $stmt->bindParam(':apellidoUsuario', $this->apellidoUsuario);
            $stmt->bindParam(':codigoUsuario', $this->codigoUsuario);
            $stmt->bindParam(':correo', $this->correo);
            $stmt->bindParam(':contrasena', $this->contrasena);
            $stmt->execute();
            return true; // Registro exitoso
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Error en el registro
        }
    }

    public function eliminarUsuario(Database $db, $codigoUsuario) { 
        try {
            $conn = $db->getConexion(); 
            $stmt = $conn->prepare("DELETE FROM usuarios WHERE codigoUsuario = :codigoUsuario");
            $stmt->bindParam(':codigoUsuario', $codigoUsuario);
            $stmt->execute();
            return true; // Eliminación exitosa
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Error en la eliminación
        }
    }

    public function recuperarCuenta($correo) { 
        // Lógica para recuperar la cuenta (ej. enviar correo electrónico)
        // ... Implementa la lógica aquí ...
    }

    public function login(Database $db, $codigoUsuario, $contrasena) { 
        try {
            $conn = $db->getConexion(); 
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE codigoUsuario = :codigoUsuario");
            $stmt->bindParam(':codigoUsuario', $codigoUsuario);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                session_start(); 
                $_SESSION['codigoUsuario'] = $usuario['codigoUsuario'];
                $_SESSION['nombreUsuario'] = $usuario['nombreUsuario']; 
                return true; // Login exitoso
            } else {
                return false; // Credenciales incorrectas
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Error en el login
        }
    }

    public function contrasenaCorrecta($contrasena) { 
        return password_verify($contrasena, $this->contrasena);
    }

    public function actualizarPerfil(Database $db) { 
        // Lógica para actualizar el perfil del usuario en la base de datos
        // ... Implementa la lógica aquí ...
    }
}

?>