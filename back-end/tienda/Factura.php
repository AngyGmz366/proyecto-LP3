<?php

require_once 'Carrito.php';
require_once 'DetallesFactura.php';

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

    // Método para generar la factura a partir de un carrito
    public function generarFacturaDesdeCarrito(Carrito $carrito) {
        foreach ($carrito->getArticulos() as $codigoArticulo => $cantidad) {
            $articulo = obtenerArticuloPorCodigo($codigoArticulo);
            if ($articulo) {
                // Obtener el precio unitario y el nombre del artículo
                $precioUnitario = $articulo->getPrecio();
                $nombreArticulo = $articulo->getNombreArticulo();

                // Crear el DetalleFactura con la información necesaria
                $detalle = new DetallesFactura($cantidad, $precioUnitario, $nombreArticulo); 

                $this->agregarDetalle($detalle); 
            }
        }
        $carrito->setDetalleFactura($detalle); // Asignar el último detalle al carrito
        $this->calcularTotales();
    }

    // Método para agregar un detalle a la factura
    public function agregarDetalle(DetallesFactura $detalle) {
        $this->detallesFactura[] = $detalle;
    }

    // Método auxiliar para calcular los totales de la factura
    private function calcularTotales() {
        foreach ($this->detallesFactura as $detalle) {
            $this->subTotal += $detalle->getPrecioUnitario() * $detalle->getCantidad();
        }
        $this->impuestos = $this->subTotal * 0.15; // Ejemplo: 15% de impuestos
        $this->total = $this->subTotal + $this->impuestos;
    }

    // Método para mostrar la factura (puedes modificarlo para generar un PDF)
    public function verFactura() { 
        echo "Factura #" . $this->numeroFactura . "\n";
        echo "Fecha: " . $this->fechaEmision->format('Y-m-d') . "\n";
        echo "--------------------\n";
        foreach ($this->detallesFactura as $detalle) {
            echo $detalle->getNombreArticulo() . " x " . $detalle->getCantidad() . " - $" 
                 . $detalle->getPrecioUnitario() * $detalle->getCantidad() . "\n";
        }
        echo "--------------------\n";
        echo "Subtotal: $" . $this->subTotal . "\n";
        echo "Impuestos: $" . $this->impuestos . "\n";
        echo "Total: $" . $this->total . "\n";
    }
}

?>