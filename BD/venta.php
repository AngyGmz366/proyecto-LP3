<?php
class Venta {
    private $idVentaPk;
    private $fecha;
    private $subtotal;
    private $impuesto;
    private $total;
    private $idClienteFk;
    private $idEmpleadoFk;
    private $idTipoPagoFk;

    public function __construct($idVentaPk, $fecha, $subtotal, $impuesto, $total, $idClienteFk, $idEmpleadoFk, $idTipoPagoFk) {
        $this->idVentaPk = $idVentaPk;
        $this->fecha = $fecha;
        $this->subtotal = $subtotal;
        $this->impuesto = $impuesto;
        $this->total = $total;
        $this->idClienteFk = $idClienteFk;
        $this->idEmpleadoFk = $idEmpleadoFk;
        $this->idTipoPagoFk = $idTipoPagoFk;
    }
    //Getters
    public function getIdVentaPk() {
        return $this->idVentaPk;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function getImpuesto() {
        return $this->impuesto;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getIdClienteFk() {
        return $this->idClienteFk;
    }

    public function getIdEmpleadoFk() {
        return $this->idEmpleadoFk;
    }

    public function getIdTipoPagoFk() {
        return $this->idTipoPagoFk;
    }
     //Setters
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    public function setImpuesto($impuesto) {
        $this->impuesto = $impuesto;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function setIdClienteFk($idClienteFk) {
        $this->idClienteFk = $idClienteFk;
    }

    public function setIdEmpleadoFk($idEmpleadoFk) {
        $this->idEmpleadoFk = $idEmpleadoFk;
    }

    public function setIdTipoPagoFk($idTipoPagoFk) {
        $this->idTipoPagoFk = $idTipoPagoFk;
    }
}
?>