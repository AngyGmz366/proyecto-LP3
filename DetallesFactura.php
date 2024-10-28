<?php

class DetallesFactura {
    private $cantidad;
    private $precioUnitario; 
    private $nombreArticulo; // Para almacenar el nombre del artículo

    // Constructor modificado para recibir la cantidad, el precio unitario y el nombre del artículo
    public function __construct($cantidad, $precioUnitario, $nombreArticulo) { 
        $this->cantidad = $cantidad;
        $this->precioUnitario = $precioUnitario;
        $this->nombreArticulo = $nombreArticulo;
    }

    // Getters
    public function getCantidad() {
        return $this->cantidad;
    }

    public function getPrecioUnitario() {
        return $this->precioUnitario;
    }

    public function getNombreArticulo() {
        return $this->nombreArticulo;
    }

    // Métodos 
    public function calcularSubtotal() {
        return $this->cantidad * $this->precioUnitario;
    }
}

?>