<?php

class Carrito {
    private $articulos; // Map<Articulo, Cantidad>
    private $IDCarrito;

    public function __construct($IDCarrito) {
        $this->articulos = [];
        $this->IDCarrito = $IDCarrito;
    }

    // Getters
    public function getArticulos() {
        return $this->articulos;
    }

    public function getIDCarrito() {
        return $this->IDCarrito;
    }

    // Métodos
    public function agregarArticulo($articulo, $cantidad) { 
        // Verificar si el artículo ya existe en el carrito
        if (isset($this->articulos[$articulo->getID()])) {
            // Si existe, aumentar la cantidad
            $this->articulos[$articulo->getID()] += $cantidad;
        } else {
            // Si no existe, agregarlo al carrito
            $this->articulos[$articulo->getID()] = $cantidad;
        }
    }

    public function editarCarrito($articulo, $cantidad) {  
        // Verificar si el artículo existe en el carrito
        if (isset($this->articulos[$articulo->getID()])) {
            // Si la cantidad es 0, eliminar el artículo del carrito
            if ($cantidad == 0) {
                unset($this->articulos[$articulo->getID()]);
            } else {
                // Si no, actualizar la cantidad
                $this->articulos[$articulo->getID()] = $cantidad;
            }
        }
    }

    public function vaciarCarrito() { 
        // Eliminar todos los artículos del carrito
        $this->articulos = [];
    }

    public function calcularSubtotal() {
        $subtotal = 0;
        // Recorrer todos los artículos del carrito
        foreach ($this->articulos as $idArticulo => $cantidad) {
            // Obtener el artículo desde la base de datos o donde esté almacenado
            $articulo = obtenerArticuloPorID($idArticulo); // Esta función debe ser implementada
            // Sumar el precio del artículo multiplicado por la cantidad al subtotal
            $subtotal += $articulo->getPrecio() * $cantidad;
        }
        return $subtotal;
    }

    public function eliminarArticulo($articulo) {
        // Eliminar el artículo del carrito
        if (isset($this->articulos[$articulo->getID()])) {
            unset($this->articulos[$articulo->getID()]);
        }
    }
}

// Función para obtener un artículo por su ID (debe ser implementada)
function obtenerArticuloPorID($idArticulo) {
    // Lógica para obtener el artículo desde la base de datos o donde esté almacenado
    // ...
    return $articulo;
}

?>