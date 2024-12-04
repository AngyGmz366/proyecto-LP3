<?php
require_once 'BD/informacion.php';
class carrito {
    private $id_carrito_pk;
    private $id_usuario_fk;
   

    // Constructor
    public function __construct($id_carrito_pk, $id_usuario_fk) {
        $this->id_carrito_pk = $id_carrito_pk;
        $this->id_usuario_fk = $id_usuario_fk;
        
    }

    // Getters
    public function getIdCarritoPk() {
        return $this->id_carrito_pk;
    }

    public function getIdUsuarioFk() {
        return $this->id_usuario_fk;
    }

    

    // Setters
    public function setIdCarritoPk($id_carrito_pk) {
        $this->id_carrito_pk = $id_carrito_pk;
    }

    public function setIdUsuarioFk($id_usuario_fk) {
        $this->id_usuario_fk = $id_usuario_fk;
    }

    
}
?>


