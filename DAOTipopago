<?php
require_once 'BD/informacion.php';
require_once 'BD/tipo_pago';

class DAOTipopago {
    private $conn;

    public function conectar() {
        $this->conn = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function desconectar() {
        $this->conn->close();
    }

    public function getConexion() {
        return $this->conn;
    }

    // Crear un nuevo tipo de pago
    public function crearTipoPago($tipoPago) {
        $sql = "INSERT INTO tbl_tipo_pago (descripcion) VALUES (:descripcion)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descripcion', $tipoPago->getDescripcion());
        return $stmt->execute();
    }

    // Obtener un tipo de pago por su ID
    public function obtenerTipoPagoPorId($id) {
        $sql = "SELECT * FROM tbl_tipo_pago WHERE id_tipo_pago_pk = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new tipo_pago($result['id_tipo_pago_pk'], $result['descripcion']);
        }

        return null;
    }

    // Obtener todos los tipos de pago
    public function obtenerTodosLosTiposPago() {
        $sql = "SELECT * FROM tbl_tipo_pago";
        $stmt = $this->conn->query($sql);
        $tiposPago = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tiposPago[] = new tipo_pago($row['id_tipo_pago_pk'], $row['descripcion']);
        }

        return $tiposPago;
    }

    // Actualizar un tipo de pago
    public function actualizarTipoPago($tipoPago) {
        $sql = "UPDATE tbl_tipo_pago SET descripcion = :descripcion WHERE id_tipo_pago_pk = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descripcion', $tipoPago->getDescripcion());
        $stmt->bindParam(':id', $tipoPago->getIdTipoPagoPk());
        return $stmt->execute();
    }

    // Eliminar un tipo de pago
    public function eliminarTipoPago($id) {
        $sql = "DELETE FROM tbl_tipo_pago WHERE id_tipo_pago_pk = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

?>
