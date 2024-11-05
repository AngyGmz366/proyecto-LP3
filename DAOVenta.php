<?php
require_once 'BD/informacion.php';
require_once 'BD/venta.php';

class DAOVenta {
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

    public function obtenerTodasLasVentas() {
        $this->conectar();
        $query = "SELECT * FROM tbl_venta";
        $result = $this->conect->query($query);
        $ventas = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $ventas[] = new Venta(
                    $fila['id_venta_pk'],
                    $fila['fecha'],
                    $fila['subtotal'],
                    $fila['impuesto'],
                    $fila['total'],
                    $fila['id_cliente_fk'],
                    $fila['id_empleado_fk'],
                    $fila['id_tipo_pago_fk']
                );
            }
        }

        $this->desconectar();
        return $ventas;
    }

    public function crearVenta($venta) {
        $this->conectar();
        $fecha = $this->conect->real_escape_string($venta->getFecha());
        $subtotal = $venta->getSubtotal();
        $impuesto = $venta->getImpuesto();
        $total = $venta->getTotal();
        $id_cliente_fk = $venta->getIdClienteFk();
        $id_empleado_fk = $venta->getIdEmpleadoFk();
        $id_tipo_pago_fk = $venta->getIdTipoPagoFk();

        $query = "INSERT INTO tbl_venta (fecha, subtotal, impuesto, total, id_cliente_fk, id_empleado_fk, id_tipo_pago_fk)
                  VALUES ('$fecha', '$subtotal', '$impuesto', '$total', '$id_cliente_fk', '$id_empleado_fk', '$id_tipo_pago_fk')";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function obtenerVentaPorId($id_venta_pk) {
        $this->conectar();
        $id_venta_pk = $this->conect->real_escape_string($id_venta_pk);
        $query = "SELECT * FROM tbl_venta WHERE id_venta_pk = $id_venta_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $venta = new Venta(
                $fila['id_venta_pk'],
                $fila['fecha'],
                $fila['subtotal'],
                $fila['impuesto'],
                $fila['total'],
                $fila['id_cliente_fk'],
                $fila['id_empleado_fk'],
                $fila['id_tipo_pago_fk']
            );
            $this->desconectar();
            return $venta;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarVenta($venta) {
        $this->conectar();
        $id_venta_pk = $venta->getIdVentaPk();
        $fecha = $this->conect->real_escape_string($venta->getFecha());
        $subtotal = $venta->getSubtotal();
        $impuesto = $venta->getImpuesto();
        $total = $venta->getTotal();
        $id_cliente_fk = $venta->getIdClienteFk();
        $id_empleado_fk = $venta->getIdEmpleadoFk();
        $id_tipo_pago_fk = $venta->getIdTipoPagoFk();

        $query = "UPDATE tbl_venta 
                  SET fecha = '$fecha', subtotal = '$subtotal', impuesto = '$impuesto', total = '$total', 
                      id_cliente_fk = '$id_cliente_fk', id_empleado_fk = '$id_empleado_fk', id_tipo_pago_fk = '$id_tipo_pago_fk'
                  WHERE id_venta_pk = $id_venta_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function eliminarVenta($id_venta_pk) {
        $this->conectar();
        $id_venta_pk = $this->conect->real_escape_string($id_venta_pk);
        $query = "DELETE FROM tbl_venta WHERE id_venta_pk = $id_venta_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }
}
?>