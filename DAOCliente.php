<?php
require_once 'BD/informacion.php';
require_once 'BD/cliente.php';

class DAOCliente {
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

    public function obtenerTodosLosClientes() {
        $this->conectar();
        $query = "SELECT * FROM tbl_cliente";
        $result = $this->conect->query($query);
        $clientes = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $clientes[] = new Cliente(
                    $fila['id_cliente_pk'],
                    $fila['membresia'],
                    $fila['id_tienda_fk'],
                    $fila['id_usuario_fk']
                );
            }
        }

        $this->desconectar();
        return $clientes;
    }

    public function crearCliente($cliente) {
        $this->conectar();
        $membresia = $this->conect->real_escape_string($cliente->getMembresia());
        $id_tienda_fk = $cliente->getIdTiendaFk();
        $id_usuario_fk = $cliente->getIdUsuarioFk();

        $query = "INSERT INTO tbl_cliente (membresia, id_tienda_fk, id_usuario_fk) VALUES ('$membresia', $id_tienda_fk, $id_usuario_fk)";

        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }

    public function obtenerClientePorId($id_cliente_pk) {
        $this->conectar();
        $id_cliente_pk = $this->conect->real_escape_string($id_cliente_pk);
        $query = "SELECT * FROM tbl_cliente WHERE id_cliente_pk = $id_cliente_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $cliente = new Cliente(
                $fila['id_cliente_pk'],
                $fila['membresia'],
                $fila['id_tienda_fk'],
                $fila['id_usuario_fk']
            );
            $this->desconectar();
            return $cliente;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarCliente($cliente) {
        $this->conectar();
        $id_cliente_pk = $cliente->getIdClientePk();
        $membresia = $this->conect->real_escape_string($cliente->getMembresia());
        $id_tienda_fk = $cliente->getIdTiendaFk();
        $id_usuario_fk = $cliente->getIdUsuarioFk();

        $query = "UPDATE tbl_cliente SET membresia = '$membresia', id_tienda_fk = $id_tienda_fk, id_usuario_fk = $id_usuario_fk WHERE id_cliente_pk = $id_cliente_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }

    public function eliminarCliente($id_cliente_pk) {
        $this->conectar();
        $id_cliente_pk = $this->conect->real_escape_string($id_cliente_pk);
        $query = "DELETE FROM tbl_cliente WHERE id_cliente_pk = $id_cliente_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }
}