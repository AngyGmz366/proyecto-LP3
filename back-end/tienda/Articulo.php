<?php
require_once 'Categoria.php';

class Articulo {
    private $nombreArticulo;
    private $codigoArticulo;
    private $descripcion;
    private $precio;
    private $cantidadExistencia;
    private $categorias; // Lista de objetos Categoria
    private $fotografiaArticulo; // Considerar cómo manejar la imagen

    public function __construct($nombreArticulo, $codigoArticulo, $descripcion, $precio, $cantidadExistencia, $fotografiaArticulo) {
        $this->nombreArticulo = $nombreArticulo;
        $this->codigoArticulo = $codigoArticulo;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->cantidadExistencia = $cantidadExistencia;
        $this->categorias = [];
        $this->fotografiaArticulo = $fotografiaArticulo;
    }

    // Getters
    public function getNombreArticulo() {
        return $this->nombreArticulo;
    }

    public function getCodigoArticulo() {
        return $this->codigoArticulo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCantidadExistencia() {
        return $this->cantidadExistencia;
    }

    public function getCategorias() {
        return $this->categorias;
    }

    public function getFotografiaArticulo() {
        return $this->fotografiaArticulo;
    }

    // Setters
    public function setNombreArticulo($nombreArticulo) {
        $this->nombreArticulo = $nombreArticulo;
    }

    public function setCodigoArticulo($codigoArticulo) {
        $this->codigoArticulo = $codigoArticulo;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setCantidadExistencia($cantidadExistencia) {
        $this->cantidadExistencia = $cantidadExistencia;
    }

    public function setFotografiaArticulo($fotografiaArticulo) {
        $this->fotografiaArticulo = $fotografiaArticulo;
    }

    // Métodos
    public function existenciasDisponibles() { 
        // Lógica para verificar la cantidad disponible en stock
        if ($this->cantidadExistencia > 0) {
            echo "Hay " . $this->cantidadExistencia . " unidades disponibles de " . $this->nombreArticulo;
        } else {
            echo "No hay unidades disponibles de " . $this->nombreArticulo;
        }
    }

    public function actualizarNombre($nuevoNombre) { 
        $this->nombreArticulo = $nuevoNombre;
    }

    public function reducirInventario($cantidad) {
        // Lógica para reducir la cantidad en stock
        if ($cantidad > 0 && $cantidad <= $this->cantidadExistencia) {
            $this->cantidadExistencia -= $cantidad;
            echo "Inventario actualizado. Quedan " . $this->cantidadExistencia . " unidades de " . $this->nombreArticulo;
        } else {
            echo "Cantidad inválida o no hay suficientes unidades en stock.";
        }
    }

    // Método para agregar categorías al artículo
    public function agregarCategoria(Categoria $categoria) {
        $this->categorias[] = $categoria;
    }

    public function aumentarInventario($cantidad) {
        // Lógica para aumentar la cantidad en stock
        if ($cantidad > 0) {
            $this->cantidadExistencia += $cantidad;
            echo "Inventario actualizado. Hay " . $this->cantidadExistencia . " unidades de " . $this->nombreArticulo;
        } else {
            echo "Cantidad inválida.";
        }
    }
}

?>