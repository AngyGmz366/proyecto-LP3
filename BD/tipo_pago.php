<?php
require_once 'BD/informacion.php';
class tipo_pago {
    private $id_tipo_pago_pk;
    private $descripcion;

    // Constructor
    public function __construct($id_tipo_pago_pk = null, $descripcion = null) {
        $this->id_tipo_pago_pk = $id_tipo_pago_pk;
        $this->descripcion = $descripcion;
    }

    // Getters y Setters
    public function getIdTipoPagoPk() {
        return $this->id_tipo_pago_pk;
    }

    public function setIdTipoPagoPk($id_tipo_pago_pk) {
        $this->id_tipo_pago_pk = $id_tipo_pago_pk;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}

?>
