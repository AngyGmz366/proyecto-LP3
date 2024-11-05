<?php
class TipoEmpleado {
    private $id_tipo_empleado_pk;
    private $descripcion;

    // Constructor
    public function __construct($id_tipo_empleado_pk = null, $descripcion = "") {
        $this->id_tipo_empleado_pk = $id_tipo_empleado_pk;
        $this->descripcion = $descripcion;
    }

    // Getters y Setters para cada uno de los atributos
    public function getIdTipoEmpleadoPk() {
        return $this->id_tipo_empleado_pk;
    }

    public function setIdTipoEmpleadoPk($id_tipo_empleado_pk) {
        $this->id_tipo_empleado_pk = $id_tipo_empleado_pk;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}
?>