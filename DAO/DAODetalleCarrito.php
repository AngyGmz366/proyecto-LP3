<?php
require_once 'BD/informacion.php';
require_once 'BD/detalle_carrito.php';

class DAODetalleCarrito {
    private $conect;

    public function conectar() {
        $this->conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
        if ($this->conect->connect_error) {
            die("Conexión fallida: " . $this->conect->connect_error);
        }
    }

    public function desconectar() {
        $this->conect->close();
    }

    public function obtenerTodosLosDetallesCarrito() {
        $this->conectar();
        $query = "SELECT * FROM tbl_detalle_carrito";
        $result = $this->conect->query($query);
        $detalles = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $detalles[] = new DetalleCarrito(
                    $fila['id_detalle_carrito_pk'],
                    $fila['cantidad'],
                    $fila['id_articulo_fk'],
                    $fila['id_carrito_fk']
                );
            }
        }

        $this->desconectar();
        return $detalles;
    }

    public function crearDetalleCarrito($detalleCarrito) {
        $this->conectar();
        $cantidad = $this->conect->real_escape_string($detalleCarrito->getCantidad());
        $id_articulo_fk = $detalleCarrito->getIdArticuloFk();
        $id_carrito_fk =  $detalleCarrito->getIdCarritoFk();

        $query = "INSERT INTO tbl_detalle_carrito (cantidad, id_articulo_fk, id_carrito_fk) 
                  VALUES ('$cantidad', '$id_articulo_fk', '$id_carrito_fk')";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function obtenerDetalleCarritoPorId($id_detalle_carrito_pk) {
        $this->conectar();
        $id_detalle_carrito_pk = $this->conect->real_escape_string($id_detalle_carrito_pk);
        $query = "SELECT * FROM tbl_detalle_carrito WHERE id_detalle_carrito_pk = $id_detalle_carrito_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $detalleCarrito = new DetalleCarrito(
                $fila['id_detalle_carrito_pk'],
                $fila['cantidad'],
                $fila['id_articulo_fk'],
                $fila['id_carrito_fk']
            );
            $this->desconectar();
            return $detalleCarrito;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarDetalleCarrito($detalleCarrito) {
        $this->conectar();
        $id_detalle_carrito_pk = $detalleCarrito->getIdDetalleCarritoPk();
        $cantidad = $this->conect->real_escape_string($detalleCarrito->getCantidad());
        $id_articulo_fk = $detalleCarrito->getIdArticuloFk();
        $id_carrito_fk = $detalleCarrito->getIdCarritoFk();

        $query = "UPDATE tbl_detalle_carrito 
                  SET cantidad = '$cantidad', id_articulo_fk = '$id_articulo_fk', id_carrito_fk = '$id_carrito_fk' 
                  WHERE id_detalle_carrito_pk = $id_detalle_carrito_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function eliminarDetalleCarrito($id_detalle_carrito_pk) {
        $this->conectar();
        $id_detalle_carrito_pk = $this->conect->real_escape_string($id_detalle_carrito_pk);
        $query = "DELETE FROM tbl_detalle_carrito WHERE id_detalle_carrito_pk = $id_detalle_carrito_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }
}
?>