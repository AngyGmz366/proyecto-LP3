<?php
class Database {
    private $host = "127.0.0.1";
    private $usuario = "root";
    private $contraseña = "";
    private $nombre_base_datos = "tiendaonline";
    private $conexion;

    // Constructor para establecer la conexión automáticamente
    public function __construct() {
        $this->conectar();
    }

    // Método para realizar la conexión a la base de datos
    private function conectar() {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->contraseña, $this->nombre_base_datos);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
      
    }

    // Método para obtener la conexión (para usar en otras clases)
    public function getConexion() {
        return $this->conexion;
    }

    // Método opcional para cerrar la conexión
    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }

    // Destructor para cerrar la conexión al destruir el objeto
    public function __destruct() {
        $this->cerrarConexion();
    }
}

// Ejemplo de uso
$db = new Database();
$conexion = $db->getConexion();
if ($conexion) {
    echo "Conexión exitosa";
}
?>
