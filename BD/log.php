<?php
require_once 'BD/informacion.php';
class log {
    private $id_log_pk;
    private $fecha_hora;
    private $evento;
    private $detalles;
    private $id_usuario_fk;

    // Constructor
    public function __construct($id_log_pk = null, $fecha_hora = null, $evento = null, $detalles = null, $id_usuario_fk = null) {
        $this->id_log_pk = $id_log_pk;
        $this->fecha_hora = $fecha_hora;
        $this->evento = $evento;
        $this->detalles = $detalles;
        $this->id_usuario_fk = $id_usuario_fk;
    }

    // Getters y Setters
    public function getIdLogPk() {
        return $this->id_log_pk;
    }

    public function setIdLogPk($id_log_pk) {
        $this->id_log_pk = $id_log_pk;
    }

    public function getFechaHora() {
        return $this->fecha_hora;
    }

    public function setFechaHora($fecha_hora) {
        $this->fecha_hora = $fecha_hora;
    }

    public function getEvento() {
        return $this->evento;
    }

    public function setEvento($evento) {
        $this->evento = $evento;
    }

    public function getDetalles() {
        return $this->detalles;
    }

    public function setDetalles($detalles) {
        $this->detalles = $detalles;
    }

    public function getIdUsuarioFk() {
        return $this->id_usuario_fk;
    }

    public function setIdUsuarioFk($id_usuario_fk) {
        $this->id_usuario_fk = $id_usuario_fk;
    }
}

?>
