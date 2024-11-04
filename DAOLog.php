<?php

require_once 'BD/informacion.php';
require_once 'BD/log.php';

class DAOLog {
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

    public function crearLog(Log $log) {
        $this->conectar();
        $fecha_hora = $this->conect->real_escape_string($log->getFechaHora());
        $evento = $this->conect->real_escape_string($log->getEvento());
        $detalles = $this->conect->real_escape_string($log->getDetalles());
        $id_usuario_fk = $log->getIdUsuarioFk();

        $query = "INSERT INTO tbl_log (fecha_hora, evento, detalles, id_usuario_fk) VALUES ('$fecha_hora', '$evento', '$detalles', $id_usuario_fk)";

        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }

    // Other methods (e.g., obtenerTodosLosLogs, obtenerLogPorId, actualizarLog, eliminarLog) can be implemented similarly to the DAOCliente class, adapting the SQL queries and object instantiation to match the `Log` class.

    // Example:
    public function obtenerTodosLosLogs() {
        $this->conectar();
        $query = "SELECT * FROM tbl_log";
        $result = $this->conect->query($query);
        $logs = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $logs[] = new Log(
                    $fila['id_log_pk'],
                    $fila['fecha_hora'],
                    $fila['evento'],
                    $fila['detalles'],
                    $fila['id_usuario_fk']
                );
            }
        }

        $this->desconectar();
        return $logs;
    }
    public function obtenerLogPorId($id_log_pk) {
        $this->conectar();
        $id_log_pk = $this->conect->real_escape_string($id_log_pk);
        $query = "SELECT * FROM tbl_log WHERE id_log_pk = $id_log_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $log = new Log(
                $fila['id_log_pk'],
                $fila['fecha_hora'],
                $fila['evento'],
                $fila['detalles'],
                $fila['id_usuario_fk']
            );
            $this->desconectar();
            return $log;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarLog(Log $log) {
        $this->conectar();
        $id_log_pk = $log->getIdLogPk();
        $fecha_hora = $this->conect->real_escape_string($log->getFechaHora());
        $evento = $this->conect->real_escape_string($log->getEvento());
        $detalles = $this->conect->real_escape_string($log->getDetalles());
        $id_usuario_fk = $log->getIdUsuarioFk();

        $query = "UPDATE tbl_log SET fecha_hora = '$fecha_hora', evento = '$evento', detalles = '$detalles', id_usuario_fk = $id_usuario_fk WHERE id_log_pk = $id_log_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }

    public function eliminarLog($id_log_pk) {
        $this->conectar();
        $id_log_pk = $this->conect->real_escape_string($id_log_pk);
        $query = "DELETE FROM tbl_log WHERE id_log_pk = $id_log_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();

        return $resultado === TRUE;
    }
}
