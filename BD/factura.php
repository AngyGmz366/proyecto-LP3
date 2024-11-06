<?php
require_once 'BD/informacion.php';
class factura {
    private $id_factura_pk;
    private $fecha_emision;
    private $subtotal;
    private $impuesto;
    private $total;
    private $numero_factura;
    private $id_venta_fk;

    // Constructor
    public function __construct($id_factura_pk, $fecha_emision, $subtotal, $impuesto, $total, $numero_factura, $id_venta_fk) {
        $this->id_factura_pk = $id_factura_pk;
        $this->fecha_emision = $fecha_emision;
        $this->subtotal = $subtotal;
        $this->impuesto = $impuesto;
        $this->total = $total;
        $this->numero_factura = $numero_factura;
        $this->id_venta_fk = $id_venta_fk;
    }

    // Getters y Setters
    public function getIdFacturaPk() {
        return $this->id_factura_pk;
    }

    public function setIdFacturaPk($id_factura_pk) {
        $this->id_factura_pk = $id_factura_pk;
    }

    public function getFechaEmision() {
        return $this->fecha_emision;
    }

    public function setFechaEmision($fecha_emision) {
        $this->fecha_emision = $fecha_emision;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    public function getImpuesto() {
        return $this->impuesto;
    }

    public function setImpuesto($impuesto) {
        $this->impuesto = $impuesto;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function getNumeroFactura() {
        return $this->numero_factura;
    }

    public function setNumeroFactura($numero_factura) {
        $this->numero_factura = $numero_factura;
    }

    public function getIdVentaFk() {
        return $this->id_venta_fk;
    }

    public function setIdVentaFk($id_venta_fk) {
        $this->id_venta_fk = $id_venta_fk;
    }
}

?>
