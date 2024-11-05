<?php
class DetalleCarrito {
    private $id_detalle_carrito_pk;
    private $cantidad;
    private $id_articulo_fk;
    private $id_carrito_fk;

    // Constructor
    public function __construct($id_detalle_carrito_pk = null, $cantidad = 0, $id_articulo_fk = null, $id_carrito_fk = null) {
        $this->id_detalle_carrito_pk = $id_detalle_carrito_pk;
        $this->cantidad = $cantidad;
        $this->id_articulo_fk = $id_articulo_fk;
        $this->id_carrito_fk = $id_carrito_fk;
    }

    // Getters y Setters para cada uno de los atributos
    public function getIdDetalleCarritoPk() {
        return $this->id_detalle_carrito_pk;
    }

    public function setIdDetalleCarritoPk($id_detalle_carrito_pk) {
        $this->id_detalle_carrito_pk = $id_detalle_carrito_pk;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getIdArticuloFk() {
        return $this->id_articulo_fk;
    }

    public function setIdArticuloFk($id_articulo_fk) {
        $this->id_articulo_fk = $id_articulo_fk;
    }

    public function getIdCarritoFk() {
        return $this->id_carrito_fk;
    }

    public function setIdCarritoFk($id_carrito_fk) {
        $this->id_carrito_fk = $id_carrito_fk;
    }
}
?>