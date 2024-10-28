<?php

class Venta {
    private $codigoVenta;
    private $cliente; // Objeto de la clase Cliente
    private $empleado; // Objeto de la clase Empleado
    private $fecha;
    private $articulos; // Lista de objetos Articulo
    private $metodoPago;
    private $factura; // Objeto de la clase Factura
    private $subtotal;
    private $impuesto;
    private $total;

    public function __construct($cliente, $empleado, $metodoPago) {
        $this->cliente = $cliente;
        $this->empleado = $empleado;
        $this->fecha = new DateTime();
        $this->articulos = [];
        $this->metodoPago = $metodoPago;
        $this->subtotal = 0;
        $this->impuesto = 0;
        $this->total = 0;
    }

    // Getters y setters...

    public function agregarArticulo($articulo, $cantidad) {
        // Verificar si hay suficiente stock
        if ($articulo->getStock() >= $cantidad) {
            $this->articulos[] = ['articulo' => $articulo, 'cantidad' => $cantidad];
            $this->calcularTotalCarrito(); // Actualizar el total del carrito
            $articulo->actualizarStock($articulo->getStock() - $cantidad); // Actualizar el stock del artículo
            return true;
        } else {
            return false; // No hay suficiente stock
        }
    }

    public function calcularTotalCarrito() {
        $this->subtotal = 0;
        foreach ($this->articulos as $item) {
            $this->subtotal += $item['articulo']->getPrecio() * $item['cantidad'];
        }
        $this->impuesto = $this->subtotal * 0.15; // Ejemplo: 15% de impuesto
        $this->total = $this->subtotal + $this->impuesto;
    }

    public function generarVenta() {
        // Generar un código de venta único
        $this->codigoVenta = uniqid('VENTA-'); 

        // Crear una instancia de la clase Factura
        $this->factura = new Factura($this->codigoVenta, $this->cliente, $this->empleado, $this->articulos);

        // Registrar la venta en la base de datos (lógica no implementada)
        // ...
    }

    public function cancelarVenta() {
        // Devolver los artículos al stock
        foreach ($this->articulos as $item) {
            $item['articulo']->actualizarStock($item['articulo']->getStock() + $item['cantidad']);
        }

        // Eliminar la venta de la base de datos (lógica no implementada)
        // ...
    }

    public function finalizarVenta() {
        // Generar la factura
        $this->factura->imprimirFactura();

        // Registrar la venta como finalizada en la base de datos (lógica no implementada)
        // ...
    }
}

?>