<?php
require_once 'BD/informacion.php';
class carrito {
    private $id_carrito_pk;
    private $id_usuario_fk;
    private $fecha_creacion;

    // Constructor
    public function __construct($id_carrito_pk, $id_usuario_fk, $fecha_creacion) {
        $this->id_carrito_pk = $id_carrito_pk;
        $this->id_usuario_fk = $id_usuario_fk;
        $this->fecha_creacion = $fecha_creacion;
    }

    // Getters
    public function getIdCarritoPk() {
        return $this->id_carrito_pk;
    }

    public function getIdUsuarioFk() {
        return $this->id_usuario_fk;
    }

    public function getFechaCreacion() {
        return $this->fecha_creacion;
    }

    // Setters
    public function setIdCarritoPk($id_carrito_pk) {
        $this->id_carrito_pk = $id_carrito_pk;
    }

    public function setIdUsuarioFk($id_usuario_fk) {
        $this->id_usuario_fk = $id_usuario_fk;
    }

    public function setFechaCreacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }
}
?>

?>
