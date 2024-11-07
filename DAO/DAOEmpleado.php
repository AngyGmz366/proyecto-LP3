<?php
require_once 'BD/informacion.php';
require_once 'BD/empleado.php';
require_once 'DAO/DAOUsuario.php'; // Incluir el DAOUsuario

class DAOEmpleado
{
    private $conect;

    public function conectar()
    {
        $this->conect = new mysqli(SERVIDOR, USUARIO, CLAVE, BD);
        if ($this->conect->connect_error) {
            die("Conexión fallida: " . $this->conect->connect_error);
        }
    }

    public function desconectar()
    {
        $this->conect->close();
    }

    public function crearEmpleado($empleado)
    {
        $this->conectar();

        try {
            // Iniciar una transacción
            $this->conect->begin_transaction();

            // Instanciar el DAOUsuario
            $daoUsuario = new DAOUsuario();

            // Obtener los datos del usuario del objeto Empleado
            $nombreTienda = $empleado->getNombreTienda();
            $apellidoUsuario = $empleado->getApellidoUsuario();
            $correo = $empleado->getCorreo();
            $contraseña = $empleado->getContrasena();

            // Crear el usuario usando el DAOUsuario
            $usuario = new Usuario(null, $nombreTienda, $apellidoUsuario, $correo, $contraseña, null);
            $daoUsuario->crearUsuario($usuario);
            $idUsuarioFk = $daoUsuario->obtenerUltimoIdInsertado();

            // Insertar el empleado en la tabla Empleado (usando el ID del usuario obtenido)
            $fecha_contratacion = $this->conect->real_escape_string($empleado->getFechaContratacion());
            $id_tipo_empleado_fk = $this->conect->real_escape_string($empleado->getIdTipoEmpleadoFk());
            $id_tienda_fk = $this->conect->real_escape_string($empleado->getIdTiendaFk());

            $queryEmpleado = "INSERT INTO Empleado (fecha_contratacion, id_tipo_empleado_fk, id_usuario_fk, id_tienda_fk) 
                              VALUES ('$fecha_contratacion', '$id_tipo_empleado_fk', '$idUsuarioFk', '$id_tienda_fk')";
            $this->conect->query($queryEmpleado);

            // Confirmar la transacción
            $this->conect->commit();
            $this->desconectar();

            return true;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->conect->rollback();
            $this->desconectar();

            throw $e;
        }
    }

    public function obtenerTodosLosEmpleados()
    {
        $this->conectar();
        $sql = "SELECT e.*, u.nombre_tienda, u.apellido_usuario, u.fecha_registro, te.descripcion
                FROM Empleado e
                INNER JOIN tbl_usuario u ON e.id_usuario_fk = u.id_usuario_pk
                INNER JOIN tbl_tipo_empleado te ON e.id_tipo_empleado_fk = te.id_tipo_empleado_pk";
        $result = $this->conect->query($sql);
        $empleados = [];
        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $empleados[] = new Empleado(
                    $fila['id_empleado_pk'],
                    $fila['fecha_contratacion'],
                    $fila['id_tipo_empleado_fk'],
                    $fila['id_usuario_fk'],
                    $fila['id_tienda_fk'],
                    $fila['nombre_tienda'],
                    $fila['apellido_usuario'],
                    $fila['fecha_registro'],
                    $fila['descripcion'] 
                );
            }
        }
        $this->desconectar();
        return $empleados;
    }

    public function obtenerEmpleadoPorId($id_empleado_pk)
    {
        $this->conectar();
        $id_empleado_pk = $this->conect->real_escape_string($id_empleado_pk);
        $sql = "SELECT e.*, u.nombre_tienda, u.apellido_usuario, u.fecha_registro, te.descripcion
                FROM Empleado e
                INNER JOIN tbl_usuario u ON e.id_usuario_fk = u.id_usuario_pk
                INNER JOIN tbl_tipo_empleado te ON e.id_tipo_empleado_fk = te.id_tipo_empleado_pk
                WHERE e.id_empleado_pk = '$id_empleado_pk'";
        $result = $this->conect->query($sql);
        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $empleado = new Empleado(
                $fila['id_empleado_pk'],
                $fila['fecha_contratacion'],
                $fila['id_tipo_empleado_fk'],
                $fila['id_usuario_fk'],
                $fila['id_tienda_fk'],
                $fila['nombre_tienda'],
                $fila['apellido_usuario'],
                $fila['fecha_registro'],
                $fila['descripcion'] 
            );
            $this->desconectar();
            return $empleado;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarEmpleado($empleado)
    {
        $this->conectar();

        // Obtener los datos del empleado
        $id_empleado_pk = $this->conect->real_escape_string($empleado->getIdEmpleadoPk());
        $fecha_contratacion = $this->conect->real_escape_string($empleado->getFechaContratacion());
        $id_tipo_empleado_fk = $this->conect->real_escape_string($empleado->getIdTipoEmpleadoFk());
        $id_usuario_fk = $this->conect->real_escape_string($empleado->getIdUsuarioFk());
        $id_tienda_fk = $this->conect->real_escape_string($empleado->getIdTiendaFk());

        // Actualizar el empleado en la tabla Empleado
        $queryEmpleado = "UPDATE Empleado SET 
                              fecha_contratacion='$fecha_contratacion',
                              id_tipo_empleado_fk='$id_tipo_empleado_fk', 
                              id_usuario_fk='$id_usuario_fk',
                              id_tienda_fk='$id_tienda_fk'
                              WHERE id_empleado_pk='$id_empleado_pk'";

        if ($this->conect->query($queryEmpleado) === TRUE) {
            $this->desconectar();
            return true;
        } else {
            $error_message = "Error al actualizar el empleado: " . $this->conect->error;
            $this->desconectar();
            throw new Exception($error_message);
        }
    }

    public function eliminarEmpleado($id_empleado_pk)
    {
        $this->conectar();
        $id_empleado_pk = $this->conect->real_escape_string($id_empleado_pk);
        $query = "DELETE FROM Empleado WHERE id_empleado_pk = '$id_empleado_pk'";
        $resultado = $this->conect->query($query);
        $this->desconectar();
        return $resultado === TRUE;
    }

    public function getTabla() {
        $this->conectar();
        $sql = "SELECT e.*, u.nombre_tienda, u.apellido_usuario, u.fecha_registro, te.descripcion
                FROM Empleado e
                INNER JOIN tbl_usuario u ON e.id_usuario_fk = u.id_usuario_pk
                INNER JOIN tbl_tipo_empleado te ON e.id_tipo_empleado_fk = te.id_tipo_empleado_pk";
        $result = $this->conect->query($sql);
        $this->desconectar();
        return $result;
    }

    public function filtrar($filtro) {
        $this->conectar();
        $filtro = $this->conect->real_escape_string($filtro);
        $sql = "SELECT e.*, u.nombre_tienda, u.apellido_usuario, u.fecha_registro, te.descripcion
                FROM Empleado e
                INNER JOIN tbl_usuario u ON e.id_usuario_fk = u.id_usuario_pk
                INNER JOIN tbl_tipo_empleado te ON e.id_tipo_empleado_fk = te.id_tipo_empleado_pk
                WHERE u.nombre_tienda LIKE '%$filtro%' OR u.apellido_usuario LIKE '%$filtro%' 
                OR te.descripcion LIKE '%$filtro%'";
        $result = $this->conect->query($sql);
        $this->desconectar();
        return $result;
    }
}
?>