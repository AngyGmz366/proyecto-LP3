<?php
require_once 'informacion.php';

class Usuario {
    protected $id_usuario_pk;
    protected $nombre_tienda;
    protected $apellido_usuario;
    protected $correo;
    protected $contrasena;
    protected $fecha_registro;

    /**
     * Constructor de la clase Usuario
     *
     * @param int $id_usuario_pk ID del usuario
     * @param string $nombre_tienda Nombre de la tienda
     * @param string $apellido_usuario Apellido del usuario
     * @param string $correo Correo electrónico del usuario
     * @param string $contrasena Contraseña del usuario
     * @param DateTime $fecha_registro Fecha de registro del usuario
     */
    public function __construct(
        $id_usuario_pk = null,
        $nombre_tienda = '',
        $apellido_usuario = '',
        $correo = '',
        $contrasena = '',
        $fecha_registro = null
    ) {
        $this->id_usuario_pk = $id_usuario_pk;
        $this->nombre_tienda = $nombre_tienda;
        $this->apellido_usuario = $apellido_usuario;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->fecha_registro = $fecha_registro ? $fecha_registro : new DateTime();
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
    public function setIdUsuarioPk($id_usuario_pk) {
        $this->id_usuario_pk = $id_usuario_pk;
    }
    
    public function setNombreTienda($nombre_tienda) {
        $this->nombre_tienda = $nombre_tienda;
    }

    public function setApellidoUsuario($apellido_usuario) {
        $this->apellido_usuario = $apellido_usuario;
    }

    public function setFechaRegistro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
    }

}

