<?php
require_once 'BD/informacion.php';
class Empleado {
    private $id_empleado_pk;
    private $fecha_contratacion;
    private $id_tipo_empleado_fk;
    private $id_usuario_fk;
    private $id_tienda_fk;

    // Constructor
    public function __construct($id_empleado_pk = null, $fecha_contratacion = "", $id_tipo_empleado_fk = null, $id_usuario_fk = null, $id_tienda_fk = null) {
        $this->id_empleado_pk = $id_empleado_pk;
        $this->fecha_contratacion = $fecha_contratacion;
        $this->id_tipo_empleado_fk = $id_tipo_empleado_fk;
        $this->id_usuario_fk = $id_usuario_fk;
        $this->id_tienda_fk = $id_tienda_fk;
    }

    // Getters y Setters
    public function getIdEmpleadoPk() {
        return $this->id_empleado_pk;
    }

    public function setIdEmpleadoPk($id_empleado_pk) {
        $this->id_empleado_pk = $id_empleado_pk;
    }

    public function getFechaContratacion() {
        return $this->fecha_contratacion;
    }

    public function setFechaContratacion($fecha_contratacion) {
        $this->fecha_contratacion = $fecha_contratacion;
    }

    public function getIdTipoEmpleadoFk() {
        return $this->id_tipo_empleado_fk;
    }

    public function setIdTipoEmpleadoFk($id_tipo_empleado_fk) {
        $this->id_tipo_empleado_fk = $id_tipo_empleado_fk;
    }

    public function getIdUsuarioFk() {
        return $this->id_usuario_fk;
    }

    public function setIdUsuarioFk($id_usuario_fk) {
        $this->id_usuario_fk = $id_usuario_fk;
    }

    public function getIdTiendaFk() {
        return $this->id_tienda_fk;
    }

    public function setIdTiendaFk($id_tienda_fk) {
        $this->id_tienda_fk = $id_tienda_fk;
    }
}
?>