<?php
require_once 'BD/informacion.php';
require_once 'BD/factura.php';

class DAOFactura {
    private $conect;

    // Conectar a la base de datos
    public function conectar() {
        $this->conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
        if ($this->conect->connect_error) {
            die("Conexión fallida: " . $this->conect->connect_error);
        }
    }

    // Desconectar de la base de datos
    public function desconectar() {
        $this->conect->close();
    }

    // Obtener todas las facturas
    public function obtenerTodasLasFacturas() {
        $this->conectar();
        $query = "SELECT * FROM tbl_factura";
        $result = $this->conect->query($query);
        $facturas = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $facturas[] = new Factura(
                    $fila['id_factura_pk'],
                    $fila['fecha_emision'],
                    $fila['subtotal'],
                    $fila['impuesto'],
                    $fila['total'],
                    $fila['numero_factura'],
                    $fila['id_venta_fk']
                );
            }
        }

        $this->desconectar();
        return $facturas;
    }

    // Crear una nueva factura
    public function crearFactura($factura) {
        $this->conectar();
        $fecha_emision = $factura->getFechaEmision();
        $subtotal = $factura->getSubtotal();
        $impuesto = $factura->getImpuesto();
        $total = $factura->getTotal();
        $numero_factura = $factura->getNumeroFactura();
        $id_venta_fk = $factura->getIdVentaFk();

        $query = "INSERT INTO tbl_factura (fecha_emision, subtotal, impuesto, total, numero_factura, id_venta_fk) 
                  VALUES ('$fecha_emision', $subtotal, $impuesto, $total, $numero_factura, $id_venta_fk)";
        
        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }

    // Obtener factura por ID
    public function obtenerFacturaPorId($id_factura_pk) {
        $this->conectar();
        $id_factura_pk = $this->conect->real_escape_string($id_factura_pk);
        $query = "SELECT * FROM tbl_factura WHERE id_factura_pk = $id_factura_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $factura = new Factura(
                $fila['id_factura_pk'],
                $fila['fecha_emision'],
                $fila['subtotal'],
                $fila['impuesto'],
                $fila['total'],
                $fila['numero_factura'],
                $fila['id_venta_fk']
            );
            $this->desconectar();
            return $factura;
        } else {
            $this->desconectar();
            return null;
        }
    }

    // Actualizar factura
    public function actualizarFactura($factura) {
        $this->conectar();
        $id_factura_pk = $factura->getIdFacturaPk();
        $fecha_emision = $this->conect->real_escape_string($factura->getFechaEmision());
        $subtotal = $factura->getSubtotal();
        $impuesto = $factura->getImpuesto();
        $total = $factura->getTotal();
        $numero_factura = $factura->getNumeroFactura();
        $id_venta_fk = $factura->getIdVentaFk();

        $query = "UPDATE tbl_factura SET 
                    fecha_emision = '$fecha_emision', 
                    subtotal = $subtotal, 
                    impuesto = $impuesto, 
                    total = $total, 
                    numero_factura = $numero_factura, 
                    id_venta_fk = $id_venta_fk 
                  WHERE id_factura_pk = $id_factura_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }

    // Eliminar factura
    public function eliminarFactura($id_factura_pk) {
        $this->conectar();
        $id_factura_pk = $this->conect->real_escape_string($id_factura_pk);
        $query = "DELETE FROM tbl_factura WHERE id_factura_pk = $id_factura_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }
    public function obtenerUltimoIdInsertado() {
        return $this->conect->insert_id;
    }
}

?>
