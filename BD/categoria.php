<?php
class Categoria {
    private $id_categoria_pk;
    private $nombre_categoria;
    private $descripcion;

    //Constructor
    public function __construct($id_categoria_pk= null, $nombre_categoria = "", $descripcion = "") {
        $this->id_categoria_pk = $id_categoria_pk;
        $this->nombre_categoria = $nombre_categoria;
        $this->descripcion = $descripcion;
}
//Getters y Setters para cada uno de los atributos
public function getIdCategoriaPk() {
    return $this->id_categoria_pk;
}
public function setIdCategoriaPk($id_categoria_pk) {
    $this->id_categoria_pk = $id_categoria_pk;
}

public function getNombreCategoria() {
    return $this->nombre_categoria;
}

public function setNombreCategoria($nombre_categoria) {
    $this->nombre_categoria = $nombre_categoria;
}

public function getDescripcion() {
    return $this->descripcion;
}

public function setDescripcion($descripcion) {
    $this->descripcion = $descripcion;
}
} 
?>