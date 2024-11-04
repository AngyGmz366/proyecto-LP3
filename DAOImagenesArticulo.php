<?php
require_once 'BD/informacion.php';
require_once 'BD/imagenes_articulo.php';

class DAOImagenesArticulo {
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

    public function obtenerTodasLasImagenes() {
        $this->conectar();
        $query = "SELECT * FROM tbl_imagenes_articulos";
        $result = $this->conect->query($query);
        $imagenes = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $imagenes[] = new ImagenesArticulo(
                    $fila['id_imagenes_articulos_pk'],
                    $fila['url_imagen'],
                    $fila['id_articulo_fk']
                );
            }
        }

        $this->desconectar();
        return $imagenes;
    }

    public function crearImagen($imagen) {
        $this->conectar();
        $url_imagen = $this->conect->real_escape_string($imagen->getUrlImagen());
        $id_articulo_fk = $imagen->getIdArticuloFk();

        $query = "INSERT INTO tbl_imagenes_articulos (url_imagen, id_articulo_fk) VALUES ('$url_imagen', $id_articulo_fk)";
        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }

    public function obtenerImagenPorId($id_imagenes_articulos_pk) {
        $this->conectar();
        $id_imagenes_articulos_pk = $this->conect->real_escape_string($id_imagenes_articulos_pk);
        $query = "SELECT * FROM tbl_imagenes_articulos WHERE id_imagenes_articulos_pk = $id_imagenes_articulos_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $imagen = new ImagenesArticulo(
                $fila['id_imagenes_articulos_pk'],
                $fila['url_imagen'],
                $fila['id_articulo_fk']
            );
            $this->desconectar();
            return $imagen;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarImagen($imagen) {
        $this->conectar();
        $id_imagenes_articulos_pk = $imagen->getIdImagenesArticulosPk();
        $url_imagen = $this->conect->real_escape_string($imagen->getUrlImagen());
        $id_articulo_fk = $imagen->getIdArticuloFk();

        $query = "UPDATE tbl_imagenes_articulos SET url_imagen = '$url_imagen', id_articulo_fk = $id_articulo_fk WHERE id_imagenes_articulos_pk = $id_imagenes_articulos_pk";
        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }

    public function eliminarImagen($id_imagenes_articulos_pk) {
        $this->conectar();
        $id_imagenes_articulos_pk = $this->conect->real_escape_string($id_imagenes_articulos_pk);
        $query = "DELETE FROM tbl_imagenes_articulos WHERE id_imagenes_articulos_pk = $id_imagenes_articulos_pk";
        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }
}
?>
