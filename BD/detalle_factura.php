<?php
require_once 'BD/informacion.php';
class DetalleFactura {
    private $id_detalle_factura_pk;
    private $cantidad;
    private $precio_unitario;
    private $id_factura_fk;
    private $id_carrito_fk;

    // Constructor
    public function __construct($id_detalle_factura_pk = null, $cantidad = 0, $precio_unitario = 0.0, $id_factura_fk = null, $id_carrito_fk = null) {
        $this->id_detalle_factura_pk = $id_detalle_factura_pk;
        $this->cantidad = $cantidad;
        $this->precio_unitario = $precio_unitario;
        $this->id_factura_fk = $id_factura_fk;
        $this->id_carrito_fk = $id_carrito_fk;
    }

    // Getters y Setters para cada atributo
    public function getIdDetalleFacturaPk() {
        return $this->id_detalle_factura_pk;
    }

    public function setIdDetalleFacturaPk($id_detalle_factura_pk) {
        $this->id_detalle_factura_pk = $id_detalle_factura_pk;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getPrecioUnitario() {
        return $this->precio_unitario;
    }

    public function setPrecioUnitario($precio_unitario) {
        $this->precio_unitario = $precio_unitario;
    }

    public function getIdFacturaFk() {
        return $this->id_factura_fk;
    }

    public function setIdFacturaFk($id_factura_fk) {
        $this->id_factura_fk = $id_factura_fk;
    }

    public function getIdCarritoFk() {
        return $this->id_carrito_fk;
    }

    public function setIdCarritoFk($id_carrito_fk) {
        $this->id_carrito_fk = $id_carrito_fk;
    }
}
?>