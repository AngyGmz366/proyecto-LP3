<?php
require_once 'BD/informacion.php';
require_once 'BD/empleado.php';

class DAOEmpleado {
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

    public function obtenerTodosLosEmpleados() {
        $this->conectar();
        $query = "SELECT * FROM tbl_empleado";
        $result = $this->conect->query($query);
        $empleados = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $empleados[] = new Empleado(
                    $fila['id_empleado_pk'],
                    $fila['fecha_contratacion'],
                    $fila['id_tipo_empleado_fk'],
                    $fila['id_usuario_fk'],
                    $fila['id_tienda_fk']
                );
            }
        }

        $this->desconectar();
        return $empleados;
    }

    public function crearEmpleado($empleado) {
        $this->conectar();
        $fecha_contratacion = $this->conect->real_escape_string($empleado->getFechaContratacion());
        $id_tipo_empleado_fk = $empleado->getIdTipoEmpleadoFk();
        $id_usuario_fk = $empleado->getIdUsuarioFk();
        $id_tienda_fk = $empleado->getIdTiendaFk();

        $query = "INSERT INTO tbl_empleado (fecha_contratacion, id_tipo_empleado_fk, id_usuario_fk, id_tienda_fk)
                  VALUES ('$fecha_contratacion', '$id_tipo_empleado_fk', '$id_usuario_fk', '$id_tienda_fk')";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function obtenerEmpleadoPorId($id_empleado_pk) {
        $this->conectar();
        $id_empleado_pk = $this->conect->real_escape_string($id_empleado_pk);
        $query = "SELECT * FROM tbl_empleado WHERE id_empleado_pk = $id_empleado_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $empleado = new Empleado(
                $fila['id_empleado_pk'],
                $fila['fecha_contratacion'],
                $fila['id_tipo_empleado_fk'],
                $fila['id_usuario_fk'],
                $fila['id_tienda_fk']
            );
            $this->desconectar();
            return $empleado;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarEmpleado($empleado) {
        $this->conectar();
        $id_empleado_pk = $empleado->getIdEmpleadoPk();
        $fecha_contratacion = $this->conect->real_escape_string($empleado->getFechaContratacion());
        $id_tipo_empleado_fk = $empleado->getIdTipoEmpleadoFk();
        $id_usuario_fk = $empleado->getIdUsuarioFk();
        $id_tienda_fk = $empleado->getIdTiendaFk();

        $query = "UPDATE tbl_empleado 
                  SET fecha_contratacion = '$fecha_contratacion', id_tipo_empleado_fk = '$id_tipo_empleado_fk', id_usuario_fk = '$id_usuario_fk', id_tienda_fk = '$id_tienda_fk' 
                  WHERE id_empleado_pk = $id_empleado_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function eliminarEmpleado($id_empleado_pk) {
        $this->conectar();
        $id_empleado_pk = $this->conect->real_escape_string($id_empleado_pk);
        $query = "DELETE FROM tbl_empleado WHERE id_empleado_pk = $id_empleado_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }
}
?>