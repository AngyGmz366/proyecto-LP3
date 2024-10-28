<?php

require_once 'Articulo.php'; // Incluir la clase Articulo
require_once 'DetallesFactura.php'; // Incluir la clase DetalleFactura 
class Carrito {
    private $articulos; // Map<Articulo, Cantidad>
    private $IDCarrito;
    private $cliente;     // Relación 1 a 1 con Cliente
    private $detalleFactura; // Relación 1 a 1 con DetalleFactura

    // Constructor modificado (sin DetalleFactura)
    public function __construct($IDCarrito, Cliente $cliente) { 
        $this->articulos = [];
        $this->IDCarrito = $IDCarrito;
        $this->cliente = $cliente;
        $this->detalleFactura = null; // Inicializar como null
    }

    // Getters
    public function getArticulos() {
        return $this->articulos;
    }

    public function getIDCarrito() {
        return $this->IDCarrito;
    }

    // Métodos para gestionar las relaciones
    public function setCliente(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function setDetalleFactura(DetallesFactura $detalleFactura) {
        $this->detalleFactura = $detalleFactura;
    }

    public function getDetalleFactura() {
        return $this->detalleFactura;
    }

    // Métodos
    public function agregarArticulo(Articulo $articulo, $cantidad) { 
        if (isset($this->articulos[$articulo->getCodigoArticulo()])) {
            $this->articulos[$articulo->getCodigoArticulo()] += $cantidad;
        } else {
            $this->articulos[$articulo->getCodigoArticulo()] = $cantidad;
        }
    }

    public function editarCarrito(Articulo $articulo, $cantidad) {     
        if (isset($this->articulos[$articulo->getCodigoArticulo()])) {
            if ($cantidad == 0) {
                unset($this->articulos[$articulo->getCodigoArticulo()]);
            } else {
                $this->articulos[$articulo->getCodigoArticulo()] += $cantidad; 
            }
        }
    }

    public function vaciarCarrito() { 
        $this->articulos = [];
    }

    public function calcularSubtotal() {
        $subtotal = 0;
        foreach ($this->articulos as $codigoArticulo => $cantidad) {
            $articulo = obtenerArticuloPorCodigo($codigoArticulo);
            if ($articulo) { // Verificar si se obtuvo un artículo válido
                $subtotal += $articulo->getPrecio() * $cantidad;
            }
        }
        return $subtotal;
    }

    public function eliminarArticulo(Articulo $articulo) {
        if (isset($this->articulos[$articulo->getCodigoArticulo()])) {
            unset($this->articulos[$articulo->getCodigoArticulo()]);
        }
    }
}

// Función para obtener un artículo por su ID (debe ser implementada)
function obtenerArticuloPorCodigo($codigoArticulo) {
    try {
        $conexion = new PDO('mysql:host=localhost;dbname=tu_base_de_datos', 'usuario', 'contraseña');
        $consulta = $conexion->prepare("SELECT * FROM articulos WHERE codigoArticulo = :codigoArticulo");
        $consulta->bindParam(':codigoArticulo', $codigoArticulo);
        $consulta->execute();
        $articulo = $consulta->fetchObject('Articulo'); 
        return $articulo; 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null; 
    }
}

?>