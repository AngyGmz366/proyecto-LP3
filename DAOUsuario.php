<?php
require_once 'BD/informacion.php';
require_once 'BD/usuario.php';

class DAOUsuario {
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

    public function getConexion() {
        return $this->conect;
    }

    public function verificarCredenciales($correo, $contrasena) {
        $this->conectar();
        $correo = $this->conect->real_escape_string($correo);
        $query = "SELECT * FROM tbl_usuario WHERE correo = '$correo'";
        $resultado = $this->conect->query($query);
    
        if ($resultado->num_rows == 1) {
            $fila = $resultado->fetch_assoc();
            echo "Hash en BD: " . $fila['contraseña'] . "<br>";
            echo "Contraseña ingresada: " . $contrasena . "<br>";
            
            if (password_verify($contrasena, $fila['contraseña'])) {
                echo "¡Verificación de contraseña exitosa!<br>";
                $this->desconectar();
                
                // Retornar el objeto Usuario si la verificación es exitosa
                return new Usuario(
                    $fila['id_usuario_pk'],
                    $fila['nombre_tienda'],
                    $fila['apellido_usuario'],
                    $fila['correo'],
                    $fila['contraseña'],
                    $fila['fecha_registro']
                );
            } else {
                echo "Error: La contraseña no coincide.<br>";
            }
        } else {
            echo "Error: Usuario no encontrado o múltiples usuarios con el mismo correo.<br>";
        }
    
        $this->desconectar();
        return null;
    }
    
    
    

    public function crearUsuario($usuario) {
        $this->conectar();
        $nombre_tienda = $this->conect->real_escape_string($usuario->getNombreTienda());
        $apellido_usuario = $this->conect->real_escape_string($usuario->getApellidoUsuario());
        $correo = $this->conect->real_escape_string($usuario->getCorreo());
        $contraseña = $usuario->getContrasena();
        $fecha_registro = $this->conect->real_escape_string($usuario->getFechaRegistro()->format('Y-m-d H:i:s'));
    
        $query = "INSERT INTO tbl_usuario (nombre_tienda, apellido_usuario, correo, contraseña, fecha_registro) VALUES ('$nombre_tienda', '$apellido_usuario', '$correo', '$contraseña', '$fecha_registro')";
    
        if ($this->conect->query($query) === TRUE) {
            $this->desconectar();
            return true;
        } else {
            $error_message = "Error al registrar el usuario: " . $this->conect->error;
            $this->desconectar();
            throw new Exception($error_message);
        }
    }

    public function obtenerTodosLosUsuarios() {
        $this->conectar();
        $sql = "SELECT * FROM tbl_usuario";
        $result = $this->conect->query($sql);
        $usuarios = [];
        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $usuarios[] = new Usuario(
                    $fila['id_usuario_pk'],
                    $fila['nombre_tienda'],
                    $fila['apellido_usuario'],
                    $fila['correo'],
                    $fila['contraseña'],
                    $fila['fecha_registro']
                );
            }
        }
        $this->desconectar();
        return $usuarios;
    }

    public function obtenerUsuarioPorId($id_usuario_pk) {
        $this->conectar();
        $id_usuario_pk = $this->conect->real_escape_string($id_usuario_pk);
        $query = "SELECT * FROM tbl_usuario WHERE id_usuario_pk = '$id_usuario_pk'";
        $result = $this->conect->query($query);
        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $usuario = new Usuario(
                $fila['id_usuario_pk'],
                $fila['nombre_tienda'],
                $fila['apellido_usuario'],
                $fila['correo'],
                $fila['contraseña'],
                $fila['fecha_registro']
            );
            $this->desconectar();
            return $usuario;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarUsuario($usuario) {
        $this->conectar();
        $id_usuario_pk = $this->conect->real_escape_string($usuario->getIdUsuarioPk());
        $nombre_tienda = $this->conect->real_escape_string($usuario->getNombreTienda());
        $apellido_usuario = $this->conect->real_escape_string($usuario->getApellidoUsuario());
        $correo = $this->conect->real_escape_string($usuario->getCorreo());
        $contrasena = $this->conect->real_escape_string($usuario->getContrasena());
        $contrasena_hashed = password_hash($contrasena, PASSWORD_DEFAULT);
        $query = "UPDATE tbl_usuario SET nombre_tienda='$nombre_tienda', apellido_usuario='$apellido_usuario', correo='$correo', contraseña='$contrasena_hashed' WHERE id_usuario_pk='$id_usuario_pk'";
        $resultado = $this->conect->query($query);
        $this->desconectar();
        return $resultado === TRUE;
    }

    public function eliminarUsuario($id_usuario_pk) {
        $this->conectar();
        $id_usuario_pk = $this->conect->real_escape_string($id_usuario_pk);
        $query = "DELETE FROM tbl_usuario WHERE id_usuario_pk = '$id_usuario_pk'";
        $resultado = $this->conect->query($query);
        $this->desconectar();
        return $resultado === TRUE;
    }

    public function obtenerIdPerfilPorUsuario($id_usuario_pk) {
        $this->conectar();
        $query = "SELECT idPerfil FROM Perfiles WHERE id_usuario_pk = ?";
        $stmt = $this->conect->prepare($query);
        $stmt->bind_param('i', $id_usuario_pk);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $this->desconectar();
        return $row['idPerfil'] ?? null;
    }

    public function ejecutarConsulta($sql, $params) {
        $this->conectar();
        $stmt = $this->conect->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $this->conect->error);
        }
        if ($params) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $this->desconectar();
        return $result;
    }

    public function obtenerIdUsuarioPorCorreo($correo) {
        $this->conectar();
        $sql = "SELECT id_usuario_pk FROM tbl_usuario WHERE correo = ?";
        $stmt = $this->conect->prepare($sql);
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $this->desconectar();
        return $row['id_usuario_pk'] ?? null;
    }

    public function obtenerUltimoIdInsertado() {
        return $this->conect->insert_id;
    }
}
?>
