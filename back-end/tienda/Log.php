<?php
require_once 'Usuario.php';

class Log {
    private $fechaHora;
    private $accion; 
    private $usuario; // Objeto de la clase Usuario

    public function __construct($accion, Usuario $usuario) {
        $this->fechaHora = new DateTime();
        $this->accion = $accion;
        $this->usuario = $usuario;
    }

    // Getters
    public function getFechaHora() {
        return $this->fechaHora;
    }

    public function getAccion() {
        return $this->accion;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    // Setters
    public function setAccion($accion) {
        $this->accion = $accion;
    }

    // Métodos
    public function registrarLog() { /* ... */ }
}

?>