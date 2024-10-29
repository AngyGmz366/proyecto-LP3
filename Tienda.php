<?php

class Tienda {
    private $nombre; 
    private $direccion; 
    private $telefono; 
    // ... otros atributos de la tienda

    public function __construct($nombre, $direccion, $telefono) {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
    }

    // Getters
    public function getNombre() {
        return $this->nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    // Setters
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    
}

?>