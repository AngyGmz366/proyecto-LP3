<?php

class DetallesFactura {
    private $articulo; // Objeto Articulo
    private $cantidad;
    private $precioUnitario;

    public function __construct(Articulo $articulo, $cantidad) {
        $this->articulo = $articulo;
        $this->cantidad = $cantidad;
        $this->precioUnitario = $articulo->getPrecio();
    }

    // Getters
    public function getArticulo() {
        return $this->articulo;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getPrecioUnitario() {
        return $this->precioUnitario;
    }

    // Métodos 
    public function calcularSubtotal() {
        return $this->cantidad * $this->precioUnitario;
    }
}

?>