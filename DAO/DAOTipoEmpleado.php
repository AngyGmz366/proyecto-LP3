<?php
require_once 'BD/informacion.php';
require_once 'BD/tipo_empleado.php';

class DAOTipoEmpleado {
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

    public function obtenerTodosLosTiposEmpleado() {
        $this->conectar();
        $query = "SELECT * FROM tbl_tipo_empleado";
        $result = $this->conect->query($query);
        $tiposEmpleado = [];

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $tiposEmpleado[] = new TipoEmpleado(
                    $fila['id_tipo_empleado_pk'],
                    $fila['descripcion']
                );
            }
        }

        $this->desconectar();
        return $tiposEmpleado;
    }

    public function crearTipoEmpleado($tipoEmpleado) {
        $this->conectar();
        $descripcion = $this->conect->real_escape_string($tipoEmpleado->getDescripcion());

        $query = "INSERT INTO tbl_tipo_empleado (descripcion) 
                  VALUES ('$descripcion')";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function obtenerTipoEmpleadoPorId($id_tipo_empleado_pk) {
        $this->conectar();
        $id_tipo_empleado_pk = $this->conect->real_escape_string($id_tipo_empleado_pk);
        $query = "SELECT * FROM tbl_tipo_empleado WHERE id_tipo_empleado_pk = $id_tipo_empleado_pk";
        $result = $this->conect->query($query);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $tipoEmpleado = new TipoEmpleado(
                $fila['id_tipo_empleado_pk'],
                $fila['descripcion']
            );
            $this->desconectar();
            return $tipoEmpleado;
        } else {
            $this->desconectar();
            return null;
        }
    }

    public function actualizarTipoEmpleado($tipoEmpleado) {
        $this->conectar();
        $id_tipo_empleado_pk = $tipoEmpleado->getIdTipoEmpleadoPk();
        $descripcion = $this->conect->real_escape_string($tipoEmpleado->getDescripcion());

        $query = "UPDATE tbl_tipo_empleado 
                  SET descripcion = '$descripcion' 
                  WHERE id_tipo_empleado_pk = $id_tipo_empleado_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }

    public function eliminarTipoEmpleado($id_tipo_empleado_pk) {
        $this->conectar();
        $id_tipo_empleado_pk = $this->conect->real_escape_string($id_tipo_empleado_pk);
        $query = "DELETE FROM tbl_tipo_empleado WHERE id_tipo_empleado_pk = $id_tipo_empleado_pk";

        $resultado = $this->conect->query($query);
        $this->desconectar();
        
        return $resultado === TRUE;
    }
    public function getTabla(){
        $this->conectar();
        $sql = "SELECT * FROM tbl_tipo_empleado";
        $res = $this->conect->query($sql);
        $tabla = "<table class='table table-dark'>"
                . "<thead class='thead thead-light'>";
        $tabla .= "<tr><th>ID Tipo Empleado</th><th>Descripción</th><th>Acción</th></tr></thead><tbody>";

        while($fila = mysqli_fetch_assoc($res)){
            $tabla .= "<tr>"
                    ."<td>".$fila["id_tipo_empleado_pk"]."</td>"
                    ."<td>".$fila["descripcion"]."</td>"
                    ."<td><a href=\"javascript:cargar('".$fila["id_tipo_empleado_pk"]."','".$fila["descripcion"]."')\">Seleccionar</a></td>" 
                    ."</tr>";         
        }
        $tabla .="</tbody></table>";
        $res->close();
        $this->desconectar();                
        return $tabla;
    }

    public function filtrar($valor, $criterio){
        $sql     =   "SELECT * FROM tbl_tipo_empleado WHERE $criterio LIKE '%$valor%'";
        $this->conectar();                                  
        $res = $this->conect->query($sql);     
        $tabla = "<table class='table table-dark'>"
                . "<thead class='thead thead-light'>";
        $tabla .= "<tr><th>ID Tipo Empleado</th><th>Descripción</th><th>Acción</th></tr></thead><tbody>";

        while($fila = mysqli_fetch_assoc($res)){
            $tabla .= "<tr>"
                    ."<td>".$fila["id_tipo_empleado_pk"]."</td>"
                    ."<td>".$fila["descripcion"]."</td>"
                    ."<td><a href=\"javascript:cargar('".$fila["id_tipo_empleado_pk"]."','".$fila["descripcion"]."')\">Seleccionar</a></td>" 
                    ."</tr>";         
        }
        $tabla .="</tbody></table>";
        $res->close();
        $this->desconectar();                   
        return $tabla;
    }

}
?>
