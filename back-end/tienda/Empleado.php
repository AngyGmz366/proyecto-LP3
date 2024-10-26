<?php
require_once 'Usuario.php'; 

class Empleado extends Usuario {
    private $fechaContratacion;
    private $tipoEmpleado; // "admin" o "empleado normal"
    private $idEmpleado;
    private $articulos; // List<Articulo> -  Array de objetos Articulo
    private $log; // Atributo para la relación 1 a 1 con Log

    public function __construct($nombreUsuario, $apellidoUsuario, $codigoUsuario, $correo, $contrasena, $idEmpleado, $fechaContratacion, $tipoEmpleado, $log = null) {
        parent::__construct($nombreUsuario, $apellidoUsuario, $codigoUsuario, $correo, $contrasena);
        $this->fechaContratacion = $fechaContratacion;
        $this->tipoEmpleado = $tipoEmpleado;
        $this->idEmpleado = $idEmpleado;
        $this->log = $log;
        $this->articulos = []; // Inicializar la lista de artículos vacía
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

    public function getArticulos() {
        return $this->articulos;
    }

    public function getLog() {
        return $this->log;
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

    public function setLog(Log $log) {
        $this->log = $log;
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
            $stmt->bindParam(':nombre', $nombre); 
           // $stmt->bindParam(':apellido', $this->apellido);  // Usar el nombre de columna correcto
            $stmt->bindParam(':fechaContratacion', $this->fechaContratacion);
            $stmt->bindParam(':tipoEmpleado', $tipoEmpleado); 
            $stmt->execute();
            echo "Nuevo empleado registrado exitosamente";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function agregarArticulo(Articulo $articulo) {
        $this->articulos[] = $articulo;
    }
}

?>