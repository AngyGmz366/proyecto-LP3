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
                    $fila['id_cliente_fk']
                    
                );
            }
        }
        $this->desconectar();
        return $carritos;
    }

    public function crearCarrito() {
        $this->conectar();
    
        // Consulta para insertar un nuevo carrito
        $query = "INSERT INTO tbl_carrito (id_cliente_fk) VALUES (NULL)"; 
        $resultado = $this->conect->query($query);
    
        // Verificar si ocurrió un error al ejecutar la consulta
        if (!$resultado) {
            error_log("Error en crearCarrito: " . $this->conect->error); 
        }
    
        $this->desconectar();
        return $resultado; // Retorna true si la consulta fue exitosa, false de lo contrario
    }
    
    
    public function obtenerCarritoPorId($id_carrito_pk) {
        $this->conectar();
    
        // Prepara la consulta para evitar inyección SQL
        $query = "SELECT * FROM tbl_carrito WHERE id_carrito_pk = ?";
        $stmt = $this->conect->prepare($query);
        $stmt->bind_param("i", $id_carrito_pk); // 'i' indica un entero
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $carrito = new Carrito($fila['id_carrito_pk'], $fila['id_cliente_fk']); // Ajusta según tu clase Carrito
            $this->desconectar();
            return $carrito;
        } else {
            $this->desconectar();
            return null; // No se encontró el carrito
        }
    }
    public function actualizarCarrito($carrito) {
        $this->conectar();
    
        // Prepara la consulta para actualizar el carrito
        $query = "UPDATE tbl_carrito SET id_cliente_fk = ? WHERE id_carrito_pk = ?";
        $stmt = $this->conect->prepare($query);
        $stmt->bind_param("ii", $carrito->getIdUsuarioFk(), $carrito->getIdCarritoPk());
    
        $resultado = $stmt->execute();
        $this->desconectar();
        return $resultado; // Retorna true si la actualización fue exitosa
    }
    public function eliminarCarrito($id_carrito_pk) {
        $this->conectar();
    
        // Prepara la consulta para eliminar el carrito
        $query = "DELETE FROM tbl_carrito WHERE id_carrito_pk = ?";
        $stmt = $this->conect->prepare($query);
        $stmt->bind_param("i", $id_carrito_pk);
    
        $resultado = $stmt->execute();
        $this->desconectar();
        return $resultado; // Retorna true si la eliminación fue exitosa
    }
        

    
   

    public function obtenerCarritoActual() {
        $this->conectar();
    
        $query = "SELECT * FROM tbl_carrito ORDER BY id_carrito_pk DESC LIMIT 1";
        $result = $this->conect->query($query);
    
        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $carrito = new Carrito($fila['id_carrito_pk'], $fila['id_cliente_fk']); // Ajusta según tu clase Carrito
            $this->desconectar();
            return $carrito;
        } else {
            $this->desconectar();
            return null; // No existe un carrito actual
        }
    }

    
    
}
?>
