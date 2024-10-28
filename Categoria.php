<?php

class Categoria {
    private $nombreCategoria;
    private $descripcion;
    private $idCategoria;

    public function __construct($nombreCategoria, $descripcion, $idCategoria) {
        $this->nombreCategoria = $nombreCategoria;
        $this->descripcion = $descripcion;
        $this->idCategoria = $idCategoria;
    }

    // Getters
    public function getNombreCategoria() {
        return $this->nombreCategoria;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    // Setters
    public function setNombreCategoria($nombreCategoria) {
        $this->nombreCategoria = $nombreCategoria;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    // Métodos 
    public function agregarCategoria() { 
        try {
            $conn = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("INSERT INTO categorias (nombreCategoria, descripcion) 
                                    VALUES (:nombreCategoria, :descripcion)");
            $stmt->bindParam(':nombreCategoria', $this->nombreCategoria);
            $stmt->bindParam(':descripcion', $this->descripcion);
            $stmt->execute();
            echo "Nueva categoría agregada exitosamente";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function eliminarCategoria($idCategoria) { 
        try {
            $conn = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("DELETE FROM categorias WHERE idCategoria = :idCategoria");
            $stmt->bindParam(':idCategoria', $idCategoria);
            $stmt->execute();
            echo "Categoría eliminada exitosamente";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function actualizarCategoria($idCategoria) { 
        try {
            $conn = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("UPDATE categorias SET 
                                        nombreCategoria = :nombreCategoria, 
                                        descripcion = :descripcion
                                    WHERE idCategoria = :idCategoria");
            $stmt->bindParam(':nombreCategoria', $this->nombreCategoria);
            $stmt->bindParam(':descripcion', $this->descripcion);
            $stmt->bindParam(':idCategoria', $idCategoria);
            $stmt->execute();
            echo "Categoría actualizada exitosamente";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>