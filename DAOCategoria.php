<?php
require_once 'BD/informacion.php';
require_once 'BD/categoria.php';

class DAOCategoria {
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

    public function obtenerTodasLasCategorias() {
        $this->conectar();
        $query = "SELECT * FROM tbl_categoria";
        $result = $this->conect->query($query);
        $categorias = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $categorias[] = new Categoria(
                    $fila['id_categoria_pk'],
                    $fila['nombre_categoria'],
                    $fila['descripcion']
                );
            }
        }

        $this->desconectar();
        return $categorias;
    }

    public function crearCategoria($categoria) {
        $this->conectar();
        $nombre_categoria = $this->conect->real_escape_string($categoria->getNombreCategoria());
        $descripcion = $this->conect->real_escape_string($categoria->getDescripcion());

        $query = "INSERT INTO tbl_categoria (nombre_categoria, descripcion) 
                  VALUES ('$nombre_categoria', '$descripcion')";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function obtenerCategoriaPorId($id_categoria_pk) {
        $this->conectar();
        $id_categoria_pk = $this->conect->real_escape_string($id_categoria_pk);
        $query = "SELECT * FROM tbl_categoria WHERE id_categoria_pk = $id_categoria_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $categoria = new Categoria(
                $fila['id_categoria_pk'],
                $fila['nombre_categoria'],
                $fila['descripcion']
            );
            $this->desconectar();
            return $categoria;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarCategoria($categoria) {
        $this->conectar();
        $id_categoria_pk = $categoria->getIdCategoriaPk();
        $nombre_categoria = $this->conect->real_escape_string($categoria->getNombreCategoria());
        $descripcion = $this->conect->real_escape_string($categoria->getDescripcion());

        $query = "UPDATE tbl_categoria 
                  SET nombre_categoria = '$nombre_categoria', descripcion = '$descripcion' 
                  WHERE id_categoria_pk = $id_categoria_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function eliminarCategoria($id_categoria_pk) {
        $this->conectar();
        $id_categoria_pk = $this->conect->real_escape_string($id_categoria_pk);
        $query = "DELETE FROM tbl_categoria WHERE id_categoria_pk = $id_categoria_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }
}
?>