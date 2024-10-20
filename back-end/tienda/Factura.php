<?php

class Factura {
    private $numeroFactura;
    private $fechaEmision;
    private $idVenta;
    private $subTotal;
    private $impuestos;
    private $total;
    private $detallesFactura; // Array para almacenar los detalles de la factura

    public function __construct($numeroFactura, $idVenta) {
        $this->numeroFactura = $numeroFactura;
        $this->fechaEmision = new DateTime();
        $this->idVenta = $idVenta;
        $this->subTotal = 0; 
        $this->impuestos = 0; 
        $this->total = 0; 
        $this->detallesFactura = [];
    }

    // Getters
    public function getNumeroFactura() {
        return $this->numeroFactura;
    }

    public function getFechaEmision() {
        return $this->fechaEmision;
    }

    public function getIdVenta() {
        return $this->idVenta;
    }

    public function getSubTotal() {
        return $this->subTotal;
    }

    public function getImpuestos() {
        return $this->impuestos;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getDetallesFactura() {
        return $this->detallesFactura;
    }

    // Métodos
    public function generarFactura($detallesFactura) { 
        // Lógica para generar la factura (ej. calcular totales, imprimir)
        $this->detallesFactura = $detallesFactura; 
        $this->calcularTotales();
        $this->imprimirFactura();
    }

    public function verFactura() { 
        // Lógica para mostrar la factura (ej. generar un PDF)
        // ... implementación para generar PDF ...
        echo "Mostrando la factura en formato PDF..."; 
    }

    // Método auxiliar para calcular los totales de la factura
    private function calcularTotales() {
        foreach ($this->detallesFactura as $detalle) {
            $this->subTotal += $detalle->getArticulo()->getPrecio() * $detalle->getCantidad();
        }
        $this->impuestos = $this->subTotal * 0.15; // Ejemplo: 15% de impuestos
        $this->total = $this->subTotal + $this->impuestos;
    }

    // Método auxiliar para imprimir la factura en formato legible (ejemplo)
    private function imprimirFactura() {
        echo "Factura #" . $this->numeroFactura . "\n";
        echo "Fecha: " . $this->fechaEmision->format('Y-m-d') . "\n";
        echo "--------------------\n";
        foreach ($this->detallesFactura as $detalle) {
            $articulo = $detalle->getArticulo();
            echo $articulo->getNombreArticulo() . " x " . $detalle->getCantidad() . " - $" 
                 . $articulo->getPrecio() * $detalle->getCantidad() . "\n";
        }
        echo "--------------------\n";
        echo "Subtotal: $" . $this->subTotal . "\n";
        echo "Impuestos: $" . $this->impuestos . "\n";
        echo "Total: $" . $this->total . "\n";
    }
}

?>