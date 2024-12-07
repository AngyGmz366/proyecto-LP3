<?php
require_once 'BD/informacion.php';
require_once 'BD/articulo.php';

class DAOArticulo {
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

    public function obtenerTodosLosArticulos() {
        $this->conectar();
        $query = "SELECT * FROM tbl_articulo";
        $result = $this->conect->query($query);
        $articulos = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $articulos[] = new Articulo(
                    $fila['id_articulo_pk'],
                    $fila['nombre_articulo'],
                    $fila['descripcion'],
                    $fila['precio_unitario'],
                    $fila['inventario'],
                    $fila['id_categoria_fk']
                );
            }
        }

        $this->desconectar();
        return $articulos;
    }

    public function crearArticulo($articulo) {
        $this->conectar();
        $nombre_articulo = $this->conect->real_escape_string($articulo->getNombreArticulo());
        $descripcion = $this->conect->real_escape_string($articulo->getDescripcion());
        $precio_unitario = $articulo->getPrecioUnitario();
        $inventario = $articulo->getInventario();
        $id_categoria_fk = $articulo->getIdCategoriaFk();
                
        $query = "INSERT INTO tbl_articulo (nombre_articulo, descripcion, precio_unitario, inventario, id_categoria_fk) VALUES ('$nombre_articulo', '$descripcion', '$precio_unitario', '$inventario', '$id_categoria_fk')";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function obtenerArticuloPorId($id_articulo_pk) {
        $this->conectar();
        $id_articulo_pk = $this->conect->real_escape_string($id_articulo_pk);
        $query = "SELECT * FROM tbl_articulo WHERE id_articulo_pk = $id_articulo_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $articulo = new Articulo(
                $fila['id_articulo_pk'],
                $fila['nombre_articulo'],
                $fila['descripcion'],
                $fila['precio_unitario'],
                $fila['inventario'],
                $fila['id_categoria_fk']
            );
            $this->desconectar();
            return $articulo;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarArticulo($articulo) {
        $this->conectar();
        $id_articulo_pk = $articulo->getIdArticuloPk();
        $nombre_articulo = $this->conect->real_escape_string($articulo->getNombreArticulo());
        $descripcion = $this->conect->real_escape_string($articulo->getDescripcion());
        $precio_unitario = $articulo->getPrecioUnitario();
        $inventario = $articulo->getInventario();
        $id_categoria_fk = $articulo->getIdCategoriaFk();

        $query = "UPDATE tbl_articulo SET nombre_articulo = '$nombre_articulo', descripcion = '$descripcion', precio_unitario = $precio_unitario, inventario = $inventario, id_categoria_fk = $id_categoria_fk WHERE id_articulo_pk = $id_articulo_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function eliminarArticulo($id_articulo_pk) {
        $this->conectar();
        $id_articulo_pk = $this->conect->real_escape_string($id_articulo_pk);
        $query = "DELETE FROM tbl_articulo WHERE id_articulo_pk = $id_articulo_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }
    public function obtenerTotalArticulos() {
        $this->conectar();
        $query = "SELECT COUNT(*) AS total FROM tbl_articulo";
        $result = $this->conect->query($query);
        $fila = $result->fetch_assoc();
        $this->desconectar();
        return $fila['total'];
    }
    public function articulosPorCategoria() {
        $this->conectar();
        $query = "SELECT id_categoria_fk, COUNT(*) AS cantidad FROM tbl_articulo GROUP BY id_categoria_fk";
        $result = $this->conect->query($query);
        $datos = [];
        while ($fila = $result->fetch_assoc()) {
            $datos[] = $fila;
        }
        $this->desconectar();
        return $datos;
    }
        
}
?>
