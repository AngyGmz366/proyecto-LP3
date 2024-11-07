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

    public function agregarEmpleado($empleado) {
        $this->conectar();
        $fecha_contratacion = $this->conect->real_escape_string($empleado->getFechaContratacion());
        $id_tipo_empleado_fk = $this->conect->real_escape_string($empleado->getIdTipoEmpleadoFk());
        $id_usuario_fk = $this->conect->real_escape_string($empleado->getIdUsuarioFk());
        $id_tienda_fk = $this->conect->real_escape_string($empleado->getIdTiendaFk());

        $query = "INSERT INTO tbl_empleado (fecha_contratacion, id_tipo_empleado_fk, id_usuario_fk, id_tienda_fk) 
                  VALUES ('$fecha_contratacion', '$id_tipo_empleado_fk', '$id_usuario_fk', '$id_tienda_fk')";

        if ($this->conect->query($query) === TRUE) {
            $this->desconectar();
            return true;
        } else {
            $error_message = "Error al registrar el empleado: " . $this->conect->error;
            $this->desconectar();
            throw new Exception($error_message);
        }
    }

    public function modificarEmpleado($empleado) {
        $this->conectar();
        $id_empleado_pk = $this->conect->real_escape_string($empleado->getIdEmpleadoPk());
        $fecha_contratacion = $this->conect->real_escape_string($empleado->getFechaContratacion());
        $id_tipo_empleado_fk = $this->conect->real_escape_string($empleado->getIdTipoEmpleadoFk());
        $id_usuario_fk = $this->conect->real_escape_string($empleado->getIdUsuarioFk());
        $id_tienda_fk = $this->conect->real_escape_string($empleado->getIdTiendaFk());

        $query = "UPDATE tbl_empleado SET 
                  fecha_contratacion='$fecha_contratacion', 
                  id_tipo_empleado_fk='$id_tipo_empleado_fk', 
                  id_usuario_fk='$id_usuario_fk', 
                  id_tienda_fk='$id_tienda_fk' 
                  WHERE id_empleado_pk='$id_empleado_pk'";

        if ($this->conect->query($query) === TRUE) {
            $this->desconectar();
            return true;
        } else {
            $error_message = "Error al actualizar el empleado: " . $this->conect->error;
            $this->desconectar();
            throw new Exception($error_message);
        }
    }

    public function getTabla(){
        $this->conectar();
        $sql = "SELECT * FROM tbl_usuario";
        $res = $this->conect->query($sql);
        $tabla = "<table class='table table-dark'>"
                . "<thead class='thead thead-light'>";
        $tabla .= "<tr><th>ID Usuario</th><th>Nombre de la tienda</th><th>Correo</th>"
                ."<th>Fecha de registro</th><th>Acción</th>"
                ."</tr></thead><tbody>";
              
        while($fila = mysqli_fetch_assoc($res)){
            $tabla .= "<tr>"
                ."<td>".$fila["id_usuario_pk"]."</td>"
                ."<td>".$fila["nombre_tienda"]."</td>"
                ."<td>".$fila["correo"]."</td>"
                ."<td>".$fila["fecha_registro"]."</td>"
                ."<td><a href=\"javascript:cargar('".$fila["id_usuario_pk"]."','".$fila["nombre_tienda"]
                    ."','".$fila["correo"]."','".$fila["fecha_registro"]
                    ."')\">Seleccionar</a></td>" 
                ."</tr>";               
        }
        $tabla .="</tbody></table>";
        $res->close();
        $this->desconectar();                   
        return $tabla;
    }
    public function obtenerEmpleados() {
        $this->conectar();
        $sql = "SELECT e.id_empleado_pk, e.fecha_contratacion, te.descripcion AS tipo_empleado, u.nombre_tienda, u.apellido_usuario, u.correo 
                FROM tbl_empleado e 
                INNER JOIN tipo_empleado te ON e.id_tipo_empleado_fk = te.id_tipo_empleado_pk 
                INNER JOIN tbl_usuario u ON e.id_usuario_fk = u.id_usuario_pk";
        $res = $this->conect->query($sql);
    
        if (!$res) {
            // Manejo de errores
            error_log("Error en la consulta SQL: " . $this->conect->error);
            return "<p>Error al obtener los empleados.</p>";
        }
    
        $tabla = "<table class='table table-dark'>"
                . "<thead class='thead thead-light'>";
        $tabla .= "<tr><th>ID Empleado</th><th>Fecha de Contratación</th><th>Tipo de Empleado</th>"
                . "<th>Nombre de Tienda</th><th>Apellido</th><th>Correo</th><th>Acción</th>"
                . "</tr></thead><tbody>";
    
        while ($fila = mysqli_fetch_assoc($res)) {
            $tabla .= "<tr>"
                    . "<td>" . htmlspecialchars($fila["id_empleado_pk"]) . "</td>"
                    . "<td>" . htmlspecialchars($fila["fecha_contratacion"]) . "</td>"
                    . "<td>" . htmlspecialchars($fila["tipo_empleado"]) . "</td>"
                    . "<td>" . htmlspecialchars($fila["nombre_tienda"]) . "</td>"
                    . "<td>" . htmlspecialchars($fila["apellido_usuario"]) . "</td>"
                    . "<td>" . htmlspecialchars($fila["correo"]) . "</td>"
                    . "<td><a href=\"javascript:cargar('" . htmlspecialchars($fila["id_empleado_pk"]) . "','" . htmlspecialchars($fila["fecha_contratacion"])
                    . "','" . htmlspecialchars($fila["tipo_empleado"]) . "','" . htmlspecialchars($fila["nombre_tienda"])
                    . "','" . htmlspecialchars($fila["apellido_usuario"]) . "','" . htmlspecialchars($fila["correo"])
                    . "')\">Seleccionar</a></td>"
                    . "</tr>";
        }
        $tabla .= "</tbody></table>";
        $res->close();
        $this->desconectar();
        return $tabla;
    }
    
    
    

    public function filtrar($valor, $criterio){
        $sql    =   "SELECT * FROM tbl_usuario WHERE $criterio LIKE '%$valor%'";
        $this->conectar();                      
        $res = $this->conect->query($sql);         
        $tabla = "<table class='table table-dark'>"
                . "<thead class='thead thead-light'>";
        $tabla .= "<tr><th>ID Usuario</th><th>Nombre de la tienda</th><th>Correo</th>"
                ."<th>Fecha de registro</th><th>Acción</th>"
                ."</tr></thead><tbody>";
              
        while($fila = mysqli_fetch_assoc($res)){
            $tabla .= "<tr>"
                ."<td>".$fila["id_usuario_pk"]."</td>"
                ."<td>".$fila["nombre_tienda"]."</td>"
                ."<td>".$fila["correo"]."</td>"
                ."<td>".$fila["fecha_registro"]."</td>"
                ."<td><a href=\"javascript:cargar('".$fila["id_usuario_pk"]."','".$fila["nombre_tienda"]
                    ."','".$fila["correo"]."','".$fila["fecha_registro"]
                    ."')\">Seleccionar</a></td>" 
                ."</tr>";               
        }
        $tabla .="</tbody></table>";
        $res->close();
        $this->desconectar();                   
        return $tabla;
    }
    
}
?>
