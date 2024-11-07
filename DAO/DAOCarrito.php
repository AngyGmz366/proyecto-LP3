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

    public function crearCarrito($carrito) {
        $this->conectar();
        $id_usuario_fk = $this->conect->real_escape_string($carrito->getIdUsuarioFk());
        $fecha_creacion = $this->conect->real_escape_string($carrito->getFechaCreacion());

        $query = "INSERT INTO tbl_carrito (id_usuario_fk, fecha_creacion) VALUES ('$id_usuario_fk', '$fecha_creacion')";
        $resultado = $this->conect->query($query);
        $this->desconectar();
        return $resultado === TRUE;
    }

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

    public function eliminarCarrito($id_carrito_pk) {
        $this->conectar();
        $id_carrito_pk = $this->conect->real_escape_string($id_carrito_pk);
        $query = "DELETE FROM tbl_carrito WHERE id_carrito_pk = '$id_carrito_pk'";
        $resultado = $this->conect->query($query);
        $this->desconectar();
        return $resultado === TRUE;
    }
   
}
?>
