<?php
require_once 'Persona.php';

class Empleado extends Persona {
    private $fechaContratacion;
    private $tipoEmpleado; // "admin" o "empleado normal"
    private $idEmpleado;

    public function __construct($nombre, $apellido, $fechaContratacion, $tipoEmpleado, $idEmpleado) {
        parent::__construct($nombre, $apellido);
        $this->fechaContratacion = $fechaContratacion;
        $this->tipoEmpleado = $tipoEmpleado;
        $this->idEmpleado = $idEmpleado;
    }

    // Getters
    public function getFechaContratacion() {
        return $this->fechaContratacion;
    }

    public function getTipoEmpleado() {
        return $this->tipoEmpleado;
    }

    public function getIdEmpleado() {
        return $this->idEmpleado;
    }

    // Setters
    public function setFechaContratacion($fechaContratacion) {
        $this->fechaContratacion = $fechaContratacion;
    }

    public function setTipoEmpleado($tipoEmpleado) {
        // Validar que el tipo sea "admin" o "empleado normal"
        if ($tipoEmpleado !== "admin" && $tipoEmpleado !== "empleado normal") {
            throw new InvalidArgumentException("Tipo de empleado inválido");
        }
        $this->tipoEmpleado = $tipoEmpleado;
    }

    // Métodos
    public function realizarVenta($codigoCliente) {
        // Lógica para realizar una venta (ej. crear un objeto Venta)
        // ...
    }

    public function registrarEmpleado($nombre, $tipoEmpleado) {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("INSERT INTO empleados (nombre, apellido, fechaContratacion, tipoEmpleado) 
                                    VALUES (:nombre, :apellido, :fechaContratacion, :tipoEmpleado)");
            $stmt->bindParam(':nombre', $nombre); // Usar $nombre del argumento
            $stmt->bindParam(':apellido', $this->apellido); 
            $stmt->bindParam(':fechaContratacion', $this->fechaContratacion);
            $stmt->bindParam(':tipoEmpleado', $tipoEmpleado); // Usar $tipoEmpleado del argumento
            $stmt->execute();
            echo "Nuevo empleado registrado exitosamente";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>