<?php
require_once 'BD/informacion.php';
class Tienda {
    private $id_tienda_pk;
    private $nombre_tienda;

    // Constructor
    public function __construct($id_tienda_pk = null, $nombre_tienda = "") {
        $this->id_tienda_pk = $id_tienda_pk;
        $this->nombre_tienda = $nombre_tienda;
    }

    // Getters y Setters para cada uno de los atributos
    public function getIdTiendaPk() {
        return $this->id_tienda_pk;
    }

    public function setIdTiendaPk($id_tienda_pk) {
        $this->id_tienda_pk = $id_tienda_pk;
    }

    public function getNombreTienda() {
        return $this->nombre_tienda;
    }

    public function setNombreTienda($nombre_tienda) {
        $this->nombre_tienda = $nombre_tienda;
    }
}
?>