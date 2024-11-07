<?php
require_once 'BD/informacion.php';
require_once 'BD/tienda.php';

class DAOTienda {
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

    public function obtenerTodasLasTiendas() {
        $this->conectar();
        $query = "SELECT * FROM tbl_tienda";
        $result = $this->conect->query($query);
        $tiendas = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $tiendas[] = new Tienda(
                    $fila['id_tienda_pk'],
                    $fila['nombre_tienda']
                );
            }
        }

        $this->desconectar();
        return $tiendas;
    }

    public function crearTienda($tienda) {
        $this->conectar();
        $nombre_tienda = $this->conect->real_escape_string($tienda->getNombreTienda());

        $query = "INSERT INTO tbl_tienda (nombre_tienda) 
                  VALUES ('$nombre_tienda')";
        
        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function obtenerTiendaPorId($id_tienda_pk) {
        $this->conectar();
        $id_tienda_pk = $this->conect->real_escape_string($id_tienda_pk);
        $query = "SELECT * FROM tbl_tienda 
                  WHERE id_tienda_pk = $id_tienda_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $tienda = new Tienda(
                $fila['id_tienda_pk'],
                $fila['nombre_tienda']
            );
            $this->desconectar();
            return $tienda;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarTienda($tienda) {
        $this->conectar();
        $id_tienda_pk = $tienda->getIdTiendaPk();
        $nombre_tienda = $this->conect->real_escape_string($tienda->getNombreTienda());

        $query = "UPDATE tbl_tienda 
                  SET nombre_tienda = '$nombre_tienda' 
                  WHERE id_tienda_pk = $id_tienda_pk";
        
        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function eliminarTienda($id_tienda_pk) {
        $this->conectar();
        $id_tienda_pk = $this->conect->real_escape_string($id_tienda_pk);
        $query = "DELETE FROM tbl_tienda WHERE id_tienda_pk = $id_tienda_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }
}
?>