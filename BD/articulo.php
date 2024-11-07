<?php
require_once 'BD/informacion.php';
class Articulo {
    // Atributos de la clase según la imagen
    private $id_articulo_pk;
    private $nombre_articulo;
    private $descripcion;
    private $precio_unitario;
    private $inventario;
    private $id_categoria_fk;

    // Constructor opcional para asignar valores al crear un objeto Articulo
    public function __construct($id_articulo_pk = null, $nombre_articulo = "", $descripcion = "", $precio_unitario = 0.0, $inventario = 0, $id_categoria_fk = null) {
        $this->id_articulo_pk = $id_articulo_pk;
        $this->nombre_articulo = $nombre_articulo;
        $this->descripcion = $descripcion;
        $this->precio_unitario = $precio_unitario;
        $this->inventario = $inventario;
        $this->id_categoria_fk = $id_categoria_fk;
    }

    // Getters y Setters para cada atributo
    public function getIdArticuloPk() {
        return $this->id_articulo_pk;
    }

    public function setIdArticuloPk($id_articulo_pk) {
        $this->id_articulo_pk = $id_articulo_pk;
    }

    public function getNombreArticulo() {
        return $this->nombre_articulo;
    }

    public function setNombreArticulo($nombre_articulo) {
        $this->nombre_articulo = $nombre_articulo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getPrecioUnitario() {
        return $this->precio_unitario;
    }

    public function setPrecioUnitario($precio_unitario) {
        $this->precio_unitario = $precio_unitario;
    }

    public function getInventario() {
        return $this->inventario;
    }

    public function setInventario($inventario) {
        $this->inventario = $inventario;
    }

    public function getIdCategoriaFk() {
        return $this->id_categoria_fk;
    }

    public function setIdCategoriaFk($id_categoria_fk) {
        $this->id_categoria_fk = $id_categoria_fk;
    }
}
?>
