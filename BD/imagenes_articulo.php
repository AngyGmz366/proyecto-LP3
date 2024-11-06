<?php
require_once 'BD/informacion.php';
class ImagenesArticulo {
    // Atributos
    private $id_imagenes_articulos_pk;
    private $url_imagen;
    private $id_articulo_fk;

    // Constructor opcional
    public function __construct($id_imagenes_articulos_pk = null, $url_imagen = null, $id_articulo_fk = null) {
        $this->id_imagenes_articulos_pk = $id_imagenes_articulos_pk;
        $this->url_imagen = $url_imagen;
        $this->id_articulo_fk = $id_articulo_fk;
    }

    // Getters y Setters

    // ID Imagenes Articulos (Primary Key)
    public function getIdImagenesArticulosPk() {
        return $this->id_imagenes_articulos_pk;
    }

    public function setIdImagenesArticulosPk($id_imagenes_articulos_pk) {
        $this->id_imagenes_articulos_pk = $id_imagenes_articulos_pk;
    }

    // URL Imagen
    public function getUrlImagen() {
        return $this->url_imagen;
    }

    public function setUrlImagen($url_imagen) {
        $this->url_imagen = $url_imagen;
    }

    // ID Articulo (Foreign Key)
    public function getIdArticuloFk() {
        return $this->id_articulo_fk;
    }

    public function setIdArticuloFk($id_articulo_fk) {
        $this->id_articulo_fk = $id_articulo_fk;
    }
}
?>
