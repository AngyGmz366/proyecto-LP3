<?php
require_once 'Usuario.php'; 

class Empleado extends Usuario {
    private $fechaContratacion;
    private $tipoEmpleado; // "admin" o "empleado normal"
    private $idEmpleado;
    private $articulos; // List<Articulo> -  Array de objetos Articulo
    private $log; // Atributo para la relación 1 a 1 con Log
    private $idCategoria;  // ID de la categoría a la que pertenece 

    public function __construct($nombreUsuario, $apellidoUsuario, $codigoUsuario, $correo, $contrasena, $idEmpleado, $fechaContratacion, $tipoEmpleado, $log = null, $idCategoria = null) {
        parent::__construct($nombreUsuario, $apellidoUsuario, $codigoUsuario, $correo, $contrasena);
        $this->fechaContratacion = $fechaContratacion;
        $this->tipoEmpleado = $tipoEmpleado;
        $this->idEmpleado = $idEmpleado;
        $this->log = $log;
        $this->articulos = []; // Inicializar la lista de artículos vacía
        $this->idCategoria = $idCategoria; // Asignar la categoría al crear el empleado
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

    public function getIdCategoria() {
        return $this->idCategoria;
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

    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    // Métodos
    public function realizarVenta($codigoCliente) {
        // Lógica para realizar una venta (ej. crear un objeto Venta)
        // ...
    }

    public function registrarEmpleado($nombre, $apellido, $fechaContratacion, $tipoEmpleado) { 
        try {
            $conn = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("INSERT INTO empleados (nombre, apellido, fechaContratacion, tipoEmpleado) 
            VALUES (:nombre, :apellido, :fechaContratacion, :tipoEmpleado)");
            $stmt->bindParam(':nombre', $nombre); 
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':fechaContratacion', $fechaContratacion);
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