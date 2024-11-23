<?php
require_once 'BD/carrito.php';
require_once 'BD/informacion.php';

class DAOCarrito {
    private $conect;

    private function conectar() {
        $this->conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
        if ($this->conect->connect_error) {
            die("Conexión fallida: " . $this->conect->connect_error);
        }
    }

    private function desconectar() {
        $this->conect->close();
    }

    // Obtener todos los carritos
    public function obtenerTodosLosCarritos() {
        $this->conectar();
        $sql = "SELECT * FROM tbl_carrito";
        $result = $this->conect->query($sql);
        $carritos = [];
        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $carritos[] = new Carrito(
                    $fila['id_carrito_pk'],
                    $fila['id_usuario_fk'],
                    $fila['fecha_creacion']
                );
            }
        }
        $this->desconectar();
        return $carritos;
    }

    // Crear un carrito
    public function crearCarrito($carrito) {
        $this->conectar();
        $id_usuario_fk = $this->conect->real_escape_string($carrito->getIdUsuarioFk());
        $fecha_creacion = $this->conect->real_escape_string($carrito->getFechaCreacion());

        $query = "INSERT INTO tbl_carrito (id_usuario_fk, fecha_creacion) VALUES ('$id_usuario_fk', '$fecha_creacion')";
        $resultado = $this->conect->query($query);
        $this->desconectar();
        return $resultado === TRUE;
    }

    // Obtener un carrito por ID
    public function obtenerCarritoPorId($id_carrito_pk) {
        $this->conectar();
        $id_carrito_pk = $this->conect->real_escape_string($id_carrito_pk);
        $query = "SELECT * FROM tbl_carrito WHERE id_carrito_pk = '$id_carrito_pk'";
        $result = $this->conect->query($query);
        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $carrito = new Carrito(
                $fila['id_carrito_pk'],
                $fila['id_usuario_fk'],
                $fila['fecha_creacion']
            );
            $this->desconectar();
            return $carrito;
        } else {
            $this->desconectar();
            return null;
        }
    }

    // Actualizar carrito
    public function actualizarCarrito($carrito) {
        $this->conectar();
        $id_carrito_pk = $this->conect->real_escape_string($carrito->getIdCarritoPk());
        $id_usuario_fk = $this->conect->real_escape_string($carrito->getIdUsuarioFk());
        $fecha_creacion = $this->conect->real_escape_string($carrito->getFechaCreacion());

        $query = "UPDATE tbl_carrito SET id_usuario_fk = '$id_usuario_fk', fecha_creacion = '$fecha_creacion' WHERE id_carrito_pk = '$id_carrito_pk'";
        $resultado = $this->conect->query($query);
        $this->desconectar();
        return $resultado === TRUE;
    }

    // Eliminar carrito
    public function eliminarCarrito($id_carrito_pk) {
        $this->conectar();
        $id_carrito_pk = $this->conect->real_escape_string($id_carrito_pk);
        $query = "DELETE FROM tbl_carrito WHERE id_carrito_pk = '$id_carrito_pk'";
        $resultado = $this->conect->query($query);
        $this->desconectar();
        return $resultado === TRUE;
    }

    // ** NUEVO: Agregar producto al carrito **
    public function agregarProductoAlCarrito($idCarrito, $idArticulo, $cantidad) {
        $this->conectar();
    
        // Verificar si el producto ya está en el carrito
        $queryCheck = "SELECT * FROM tbl_detalle_carrito WHERE id_carrito_fk = '$idCarrito' AND id_articulo_fk = '$idArticulo'";
        $result = $this->conect->query($queryCheck);
    
        if ($result === false) {
            file_put_contents('debug.log', "Error en consulta: " . $this->conect->error . PHP_EOL, FILE_APPEND);
            $this->desconectar();
            return false;
        }
    
        if ($result->num_rows > 0) {
            // Si el producto ya está en el carrito, actualizar cantidad
            $queryUpdate = "UPDATE tbl_detalle_carrito SET cantidad = cantidad + $cantidad 
                            WHERE id_carrito_fk = '$idCarrito' AND id_articulo_fk = '$idArticulo'";
            if (!$this->conect->query($queryUpdate)) {
                file_put_contents('debug.log', "Error en update: " . $this->conect->error . PHP_EOL, FILE_APPEND);
            }
        } else {
            // Si el producto no está en el carrito, agregarlo
            $queryInsert = "INSERT INTO tbl_detalle_carrito (id_carrito_fk, id_articulo_fk, cantidad) 
                            VALUES ('$idCarrito', '$idArticulo', '$cantidad')";
            if (!$this->conect->query($queryInsert)) {
                file_put_contents('debug.log', "Error en insert: " . $this->conect->error . PHP_EOL, FILE_APPEND);
            }
        }
    
        $this->desconectar();
    }
    // ** NUEVO: Obtener productos del carrito **
    public function obtenerProductosDelCarrito($idCarrito) {
        $this->conectar();
        $query = "SELECT dc.id_detalle_carrito_pk, dc.cantidad, dc.id_articulo_fk, a.nombre_articulo, a.precio_unitario 
                  FROM tbl_detalle_carrito dc 
                  JOIN tbl_articulo a ON dc.id_articulo_fk = a.id_articulo_pk 
                  WHERE dc.id_carrito_fk = '$idCarrito'";
        $result = $this->conect->query($query);

        $productos = [];
        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $productos[] = [
                    'id_detalle' => $fila['id_detalle_carrito_pk'],
                    'id_articulo' => $fila['id_articulo_fk'],
                    'nombre' => $fila['nombre_articulo'],
                    'cantidad' => $fila['cantidad'],
                    'precio_unitario' => $fila['precio_unitario'],
                    'subtotal' => $fila['cantidad'] * $fila['precio_unitario']
                ];
            }
        }
        $this->desconectar();
        return $productos;
    }

    // ** NUEVO: Eliminar producto del carrito **
    public function eliminarProductoDelCarrito($idCarrito, $idArticulo) {
        $this->conectar();
        $query = "DELETE FROM tbl_detalle_carrito WHERE id_carrito_fk = '$idCarrito' AND id_articulo_fk = '$idArticulo'";
        $resultado = $this->conect->query($query);
        $this->desconectar();
        return $resultado === TRUE;
    }
}
?>
