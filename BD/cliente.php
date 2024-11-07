<?php
require_once 'BD/informacion.php';
class Cliente {
    private $id_cliente_pk;
    private $membresia;
    private $id_tienda_fk;
    private $id_usuario_fk;

    // Constructor
    
    public function __construct() {} // Constructor vacío

    // Getters
    public function getIdClientePk() {
        return $this->id_cliente_pk;
    }

    public function getMembresia() {
        return $this->membresia;
    }

    public function getIdTiendaFk() {
        return $this->id_tienda_fk;
    }

    public function getIdUsuarioFk() {
        return $this->id_usuario_fk;
    }

    // Setters
    public function setIdClientePk($id_cliente_pk) {
        $this->id_cliente_pk = $id_cliente_pk;
    }

    public function setMembresia($membresia) {
        $this->membresia = $membresia;
    }

    public function setIdTiendaFk($id_tienda_fk) {
        $this->id_tienda_fk = $id_tienda_fk;
    }

    public function setIdUsuarioFk($id_usuario_fk) {
        $this->id_usuario_fk = $id_usuario_fk;
    }
}