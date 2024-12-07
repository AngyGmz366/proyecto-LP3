<?php
require_once 'BD/informacion.php';
require_once 'BD/detalle_factura.php';

class DAODetalleFactura {
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
    public function getConexion() {
        return $this->conect;
    }

    public function obtenerTodosLosDetallesFactura() {
        $this->conectar();
        $query = "SELECT * FROM tbl_detalle_factura";
        $result = $this->conect->query($query);
        $detalles = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $detalles[] = new DetalleFactura(
                    $fila['id_detalle_factura_pk'],
                    $fila['cantidad'],
                    $fila['precio_unitario'],
                    $fila['id_factura_fk'],
                    $fila['id_carrito_fk']
                );
            }
        }

        $this->desconectar();
        return $detalles;
    }

    public function crearDetalleFactura($detalleFactura) {
        $this->conectar();
        $cantidad = $detalleFactura->getCantidad();
        $precio_unitario = $detalleFactura->getPrecioUnitario();
        $id_factura_fk = $detalleFactura->getIdFacturaFk();
        $id_carrito_fk = $detalleFactura->getIdCarritoFk();

        $query = "INSERT INTO tbl_detalle_factura (cantidad, precio_unitario, id_factura_fk, id_carrito_fk)
                  VALUES ('$cantidad', '$precio_unitario', '$id_factura_fk', '$id_carrito_fk')";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function obtenerDetalleFacturaPorId($id_detalle_factura_pk) {
        $this->conectar();
        $id_detalle_factura_pk = $this->conect->real_escape_string($id_detalle_factura_pk);
        $query = "SELECT * FROM tbl_detalle_factura WHERE id_detalle_factura_pk = $id_detalle_factura_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $detalleFactura = new DetalleFactura(
                $fila['id_detalle_factura_pk'],
                $fila['cantidad'],
                $fila['precio_unitario'],
                $fila['id_factura_fk'],
                $fila['id_carrito_fk']
            );
            $this->desconectar();
            return $detalleFactura;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarDetalleFactura($detalleFactura) {
        $this->conectar();
        $id_detalle_factura_pk = $detalleFactura->getIdDetalleFacturaPk();
        $cantidad = $detalleFactura->getCantidad();
        $precio_unitario = $detalleFactura->getPrecioUnitario();
        $id_factura_fk = $detalleFactura->getIdFacturaFk();
        $id_carrito_fk = $detalleFactura->getIdCarritoFk();

        $query = "UPDATE tbl_detalle_factura 
                  SET cantidad = '$cantidad', precio_unitario = '$precio_unitario', id_factura_fk = '$id_factura_fk', id_carrito_fk = '$id_carrito_fk' 
                  WHERE id_detalle_factura_pk = $id_detalle_factura_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function eliminarDetalleFactura($id_detalle_factura_pk) {
        $this->conectar();
        $id_detalle_factura_pk = $this->conect->real_escape_string($id_detalle_factura_pk);
        $query = "DELETE FROM tbl_detalle_factura WHERE id_detalle_factura_pk = $id_detalle_factura_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }
}
?>
