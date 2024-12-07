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

    public function crearClienteConUsuario($membresia, $id_usuario_fk) {
        $this->conectar();
        $membresia = $this->conect->real_escape_string($membresia);
        $query = "INSERT INTO tbl_cliente (membresia, id_usuario_fk) VALUES ('$membresia', $id_usuario_fk)";
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
    public function getTablaClientes() {
        $this->conectar();
        $query = "SELECT * FROM tbl_cliente"; 
        $result = $this->conect->query($query);
        $tabla = "<table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>ID Cliente</th>
                            <th>Membresía</th>
                            <th>ID Tienda</th>
                            <th>ID Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $tabla .= "<tr>
                            <td>".$fila['id_cliente_pk']."</td>
                            <td>".$fila['membresia']."</td>
                            <td>".$fila['id_tienda_fk']."</td>
                            <td>".$fila['id_usuario_fk']."</td>
                            <td>
                                <button class='btn btn-warning' onclick='cargar(".$fila['id_usuario_fk'].", \"".(isset($fila['nombre_tienda']) ? $fila['nombre_tienda'] : "")."\", \"".(isset($fila['correo']) ? $fila['correo'] : "")."\", \"".(isset($fila['fecha_registro']) ? $fila['fecha_registro'] : "")."\", ".$fila['id_cliente_pk'].", \"".$fila['membresia']."\", ".$fila['id_tienda_fk'].")'>Cargar</button> 
                            </td>
                        </tr>";
            }
        }

        $tabla .= "</tbody></table>";
        $this->desconectar();
        return $tabla;
    }
    public function obtenerTotalClientes() {
        $this->conectar();
        $query = "SELECT COUNT(*) AS total FROM tbl_cliente";
        $result = $this->conect->query($query);
        $fila = $result->fetch_assoc();
        $this->desconectar();
        return $fila['total'];
    }
    public function clientesPorMembresia() {
        $this->conectar();
        $query = "SELECT membresia, COUNT(*) AS cantidad FROM tbl_cliente GROUP BY membresia";
        $result = $this->conect->query($query);
        $datos = [];
        while ($fila = $result->fetch_assoc()) {
            $datos[] = $fila;
        }
        $this->desconectar();
        return $datos;
    }
        
}