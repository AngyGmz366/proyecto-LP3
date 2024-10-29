<?php
require_once 'Database.php';
class Usuario {
    private $id_usuario_pk; 
    private $nombre_tienda;  
    private $apellido_usuario; 
    private $correo;
    private $contrasena;
    private $fecha_registro; 

    public function __construct($nombre_tienda, $apellido_usuario, $correo, $contrasena) {
        $this->nombre_tienda = $nombre_tienda;
        $this->apellido_usuario = $apellido_usuario;
        $this->correo = $correo;
        $this->contrasena = password_hash($contrasena, PASSWORD_DEFAULT); 
        $this->fecha_registro = new DateTime(); 
    }

    // Getters
    public function getIdUsuarioPk() {
        return $this->id_usuario_pk;
    }

    public function getNombreTienda() {
        return $this->nombre_tienda;
    }

    public function getApellidoUsuario() {
        return $this->apellido_usuario;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }

    // Setters
    public function setNombreTienda($nombre_tienda) {
        $this->nombre_tienda = $nombre_tienda;
    }

    public function setApellidoUsuario($apellido_usuario) {
        $this->apellido_usuario = $apellido_usuario;
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
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre_tienda, apellido_usuario, correo, contrasena) 
            VALUES (:nombre_tienda, :apellido_usuario, :correo, :contrasena)");
            $stmt->bindParam(':nombre_tienda', $this->nombre_tienda);
            $stmt->bindParam(':apellido_usuario', $this->apellido_usuario);
            $stmt->bindParam(':correo', $this->correo);
            $stmt->bindParam(':contrasena', $this->contrasena);
            $stmt->execute();
            return true; 
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; 
        }
    }

    public function eliminarUsuario(Database $db, $id_usuario_pk) { 
        try {
            $conn = $db->getConexion(); 
            $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario_pk = :id_usuario_pk");
            $stmt->bindParam(':id_usuario_pk', $id_usuario_pk);
            $stmt->execute();
            return true; 
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; 
        }
    }

    public function recuperarCuenta($correo) { 
        // Lógica para recuperar la cuenta (ej. enviar correo electrónico)
        // ... Implementa la lógica aquí ...
    }

    public function login(Database $db, $correo, $contrasena) { // Usando "correo" para el login
        try {
            $conn = $db->getConexion(); 
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = :correo");
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                session_start(); 
                $_SESSION['id_usuario_pk'] = $usuario['id_usuario_pk'];
                $_SESSION['nombre_tienda'] = $usuario['nombre_tienda']; 
                return true; 
            } else {
                return false; 
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; 
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