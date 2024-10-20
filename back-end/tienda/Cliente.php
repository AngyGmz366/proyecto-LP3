<?php
require_once 'Persona.php';

class Cliente extends Persona {
    private $membresia; // "bronce", "plata", "oro" o null (sin membresía)
    private $carrito; // Array para almacenar los artículos del carrito

    public function __construct($nombre, $apellido, $membresia = null) {
        parent::__construct($nombre, $apellido);
        $this->setMembresia($membresia); 
        $this->carrito = []; // Inicializar el carrito vacío
    }

    // Getters
    public function getMembresia() {
        return $this->membresia;
    }

    // Setters
    public function setMembresia($membresia) {
        // Validar que la membresía sea válida
        $membresiasValidas = [null, "bronce", "plata", "oro"];
        if (!in_array($membresia, $membresiasValidas)) {
            throw new InvalidArgumentException("Membresía inválida");
        }
        $this->membresia = $membresia;
    }

    // Métodos 
    public function agregarArticulosCarrito($articulo, $cantidad) { 
        // Lógica para agregar artículos al carrito del cliente
        if ($cantidad > 0) {
            $this->carrito[$articulo] = $cantidad; 
            echo "Artículo agregado al carrito correctamente.";
        } else {
            echo "Cantidad inválida.";
        }
    }

    public function verCarrito() { 
        // Lógica para mostrar el carrito del cliente
        if (empty($this->carrito)) {
            echo "El carrito está vacío.";
        } else {
            echo "Artículos en el carrito:\n";
            foreach ($this->carrito as $articulo => $cantidad) {
                echo "- $articulo: $cantidad\n";
            }
        }
    }

    public function eliminarArticuloCarrito($articulo) { 
        // Lógica para eliminar un artículo del carrito del cliente
        if (isset($this->carrito[$articulo])) {
            unset($this->carrito[$articulo]);
            echo "Artículo eliminado del carrito.";
        } else {
            echo "El artículo no se encuentra en el carrito.";
        }
    }

    public function revisarHistorialCompras() { 
        // Lógica para mostrar el historial de compras del cliente (requiere acceso a la base de datos)
        // ... implementación con la base de datos ...
        echo "Historial de compras del cliente:\n";
        // Ejemplo: mostrar las últimas 5 compras
        echo "- Compra 1\n";
        echo "- Compra 2\n";
        echo "- Compra 3\n";
        echo "- Compra 4\n";
        echo "- Compra 5\n"; 
    }
}

?>