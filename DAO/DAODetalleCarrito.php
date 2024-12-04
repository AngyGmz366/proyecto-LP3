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
    public function obtenerDetallePorArticuloYCarrito($idCarrito, $idArticulo) {
        $this->conectar();
    
        // Consulta para verificar si ya existe el artículo en el carrito
        $query = "SELECT * FROM tbl_detalle_carrito 
                  WHERE id_carrito_fk = '$idCarrito' AND id_articulo_fk = '$idArticulo'";
        $result = $this->conect->query($query);
    
        if ($result->num_rows > 0) {
            // Si existe, devolver el detalle como un objeto DetalleCarrito
            $fila = $result->fetch_assoc();
            $detalleCarrito = new DetalleCarrito(
                $fila['id_detalle_carrito_pk'], // Clave primaria
                $fila['cantidad'],             // Cantidad actual
                $fila['id_articulo_fk'],       // ID del artículo
                $fila['id_carrito_fk']         // ID del carrito
            );
            $this->desconectar();
            return $detalleCarrito;
        } else {
            $this->desconectar();
            return null; // No existe el detalle
        }
    }
    
    public function obtenerDetallesPorCarrito($idCarrito) {
        $this->conectar();
    
        // Escapar el valor de idCarrito para evitar inyección SQL
        $idCarrito = $this->conect->real_escape_string($idCarrito);
    
        // Consulta SQL corregida
        $query = "SELECT dc.id_detalle_carrito_pk, dc.cantidad, a.nombre_articulo AS nombreArticulo, a.precio_unitario AS precio
                  FROM tbl_detalle_carrito dc
                  INNER JOIN tbl_articulo a ON dc.id_articulo_fk = a.id_articulo_pk
                  WHERE dc.id_carrito_fk = '$idCarrito'";

        // Ejecutar la consulta
        $result = $this->conect->query($query);
    
        // Verificar si la consulta falló
        if (!$result) {
            die("Error en la consulta SQL: " . $this->conect->error . " - Consulta: " . $query);
        }
    
        // Procesar los resultados
        $detalles = [];
        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $detalles[] = [
                    'idDetalle' => $fila['id_detalle_carrito_pk'],
                    'cantidad' => $fila['cantidad'],
                    'nombreArticulo' => $fila['nombreArticulo'],
                    'precio' => $fila['precio']
                ];
            }
        }
    
        $this->desconectar();
        return $detalles;
    }

    public function vaciarCarrito($idCarrito) {
        $this->conectar();
    
        // Escapar el valor de idCarrito para evitar inyección SQL
        $idCarrito = $this->conect->real_escape_string($idCarrito);
    
        // Consulta para eliminar todos los detalles del carrito
        $query = "DELETE FROM tbl_detalle_carrito WHERE id_carrito_fk = '$idCarrito'";
        $resultado = $this->conect->query($query);
    
        // Verificar si la consulta fue exitosa
        if (!$resultado) {
            die("Error al vaciar el carrito: " . $this->conect->error);
        }
    
        $this->desconectar();
        return true;
    }
    
    
}
?>