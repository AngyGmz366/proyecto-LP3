<?php

class Log {
    private $fechaHora;
    private $evento; 
    private $detalles; 
    private $idEmpleado; // Para almacenar el id del Empleado que genera el Log

    public function __construct($evento, $detalles, $idEmpleado) {
        $this->fechaHora = new DateTime();
        $this->evento = $evento;
        $this->detalles = $detalles;
        $this->idEmpleado = $idEmpleado;
    }

    // Getters
    public function getFechaHora() {
        return $this->fechaHora;
    }

    public function getEvento() {
        return $this->evento;
    }

    public function getDetalles() {
        return $this->detalles;
    }

    public function getIdEmpleado() {
        return $this->idEmpleado;
    }

    // Setters
    public function setEvento($evento) {
        $this->evento = $evento;
    }

    public function setDetalles($detalles) {
        $this->detalles = $detalles;
    }
}

?>