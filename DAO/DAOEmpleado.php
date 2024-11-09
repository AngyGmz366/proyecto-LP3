<?php
require_once 'BD/informacion.php';
require_once 'BD/empleado.php';
require_once 'DAO/DAOUsuario.php'; 
require_once 'DAO/DAOTipoEmpleado.php';
require_once 'DAO/DAOTienda.php';

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
        
        // Consulta preparada para prevenir inyección SQL
        $stmt = $this->conect->prepare("INSERT INTO tbl_empleado (fecha_contratacion, id_tipo_empleado_fk, id_usuario_fk, id_tienda_fk) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siii", 
            $empleado->getFechaContratacion(), 
            $empleado->getIdTipoEmpleadoFk(), 
            $empleado->getIdUsuarioFk(), 
            $empleado->getIdTiendaFk()
        );

        $resultado = $stmt->execute();
        $stmt->close();
        $this->desconectar();
        
        return $resultado;
    }

    public function obtenerEmpleadoPorId($id_empleado_pk) {
        $this->conectar();
        
        // Consulta preparada para prevenir inyección SQL
        $stmt = $this->conect->prepare("SELECT * FROM tbl_empleado WHERE id_empleado_pk = ?");
        $stmt->bind_param("i", $id_empleado_pk);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $empleado = new Empleado(
                $fila['id_empleado_pk'],
                $fila['fecha_contratacion'],
                $fila['id_tipo_empleado_fk'],
                $fila['id_usuario_fk'],
                $fila['id_tienda_fk']
            );
            $stmt->close();
            $this->desconectar();
            return $empleado;
        } else {
            $stmt->close();
            $this->desconectar();
            return null;
        }
    }

    public function actualizarEmpleado($empleado) {
        $this->conectar();

        // Consulta preparada para prevenir inyección SQL
        $stmt = $this->conect->prepare("UPDATE tbl_empleado SET fecha_contratacion = ?, id_tipo_empleado_fk = ?, id_usuario_fk = ?, id_tienda_fk = ? WHERE id_empleado_pk = ?");
        $stmt->bind_param("siiii", 
            $empleado->getFechaContratacion(), 
            $empleado->getIdTipoEmpleadoFk(), 
            $empleado->getIdUsuarioFk(), 
            $empleado->getIdTiendaFk(),
            $empleado->getIdEmpleadoPk()
        );

        $resultado = $stmt->execute();
        $stmt->close();
        $this->desconectar();
        
        return $resultado;
    }

    public function eliminarEmpleado($id_empleado_pk) {
        $this->conectar();

        // Consulta preparada para prevenir inyección SQL
        $stmt = $this->conect->prepare("DELETE FROM tbl_empleado WHERE id_empleado_pk = ?");
        $stmt->bind_param("i", $id_empleado_pk);

        $resultado = $stmt->execute();
        $stmt->close();
        $this->desconectar();
        
        return $resultado;
    }

    public function getTabla(){
        $this->conectar();
        // Consulta para obtener nombres en lugar de IDs
        $sql = "SELECT 
                    e.id_empleado_pk, 
                    e.fecha_contratacion, 
                    te.descripcion AS tipo_empleado,
                    u.nombre_tienda AS nombre_usuario,
                    t.nombre_tienda AS tienda
                FROM tbl_empleado e
                INNER JOIN tbl_tipo_empleado te ON e.id_tipo_empleado_fk = te.id_tipo_empleado_pk
                INNER JOIN tbl_usuario u ON e.id_usuario_fk = u.id_usuario_pk
                INNER JOIN tbl_tienda t ON e.id_tienda_fk = t.id_tienda_pk";
        $res = $this->conect->query($sql);

        $tabla = "<table class='table table-dark'>"
                 . "<thead class='thead thead-light'>";
        $tabla .= "<tr><th>ID Empleado</th><th>Fecha Contratación</th><th>Tipo Empleado</th>"
                 ."<th>Usuario</th><th>Tienda</th><th>Acción</th>"
                 ."</tr></thead><tbody>";

        while($fila = mysqli_fetch_assoc($res)){
            $tabla .= "<tr>"
                     ."<td>".$fila["id_empleado_pk"]."</td>"
                     ."<td>".$fila["fecha_contratacion"]."</td>"
                     ."<td>".$fila["tipo_empleado"]."</td>" 
                     ."<td>".$fila["nombre_usuario"]."</td>" 
                     ."<td>".$fila["tienda"]."</td>" 
                     ."<td><a href=\"javascript:cargar('".$fila["id_empleado_pk"]."','".$fila["fecha_contratacion"]
                        ."','".$fila["tipo_empleado"]."','".$fila["nombre_usuario"]
                        ."','".$fila["tienda"]."')\">Seleccionar</a></td>" 
                     ."</tr>";   
        }
        $tabla .="</tbody></table>";
        $res->close();
        $this->desconectar();         
        return $tabla;
    }

    public function filtrar($valor, $criterio){
        $this->conectar();

        // Consulta preparada para prevenir inyección SQL
        $sql = "SELECT 
                    e.id_empleado_pk, 
                    e.fecha_contratacion, 
                    te.descripcion AS tipo_empleado,
                    u.nombre_tienda AS nombre_usuario,
                    t.nombre_tienda AS tienda
                FROM tbl_empleado e
                INNER JOIN tbl_tipo_empleado te ON e.id_tipo_empleado_fk = te.id_tipo_empleado_pk
                INNER JOIN tbl_usuario u ON e.id_usuario_fk = u.id_usuario_pk
                INNER JOIN tbl_tienda t ON e.id_tienda_fk = t.id_tienda_pk
                WHERE `$criterio` LIKE ?";

        $stmt = $this->conect->prepare($sql);
        if ($stmt) {
            $valor = '%' . $valor . '%';
            $stmt->bind_param("s", $valor);
            $stmt->execute();
            $res = $stmt->get_result();

            $tabla = "<table class='table table-dark'>"
                     . "<thead class='thead thead-light'>";
            $tabla .= "<tr><th>ID Empleado</th><th>Fecha Contratación</th><th>Tipo Empleado</th>"
                     ."<th>Usuario</th><th>Tienda</th><th>Acción</th>"
                     ."</tr></thead><tbody>";
            
            while($fila = mysqli_fetch_assoc($res)){
                $tabla .= "<tr>"
                         ."<td>".$fila["id_empleado_pk"]."</td>"
                         ."<td>".$fila["fecha_contratacion"]."</td>"
                         ."<td>".$fila["tipo_empleado"]."</td>" 
                         ."<td>".$fila["nombre_usuario"]."</td>" 
                         ."<td>".$fila["tienda"]."</td>" 
                         ."<td><a href=\"javascript:cargar('".$fila["id_empleado_pk"]."','".$fila["fecha_contratacion"]
                            ."','".$fila["tipo_empleado"]."','".$fila["nombre_usuario"]
                            ."','".$fila["tienda"]."')\">Seleccionar</a></td>" 
                         ."</tr>";   
            }
            $tabla .="</tbody></table>";
            $stmt->close(); // Cerrar la consulta preparada
            $this->desconectar();         
            return $tabla;
        } else {
            // Manejar el error de la consulta preparada
            printf("Error al preparar la consulta: %s\n", $this->conect->error);
            $this->desconectar();  
            return "Error al obtener la tabla"; // O manejar el error de otra forma
        }
    }

    public function obtenerEmpleadosConDetalles() {
        $this->conectar();
    
        $query = "SELECT 
                    e.id_empleado_pk, 
                    e.fecha_contratacion, 
                    te.descripcion AS tipo_empleado,
                    t.nombre_tienda AS tienda,
                    u.id_usuario_pk,
                    u.nombre_tienda AS nombre_usuario,
                    u.correo
                FROM tbl_empleado e
                INNER JOIN tbl_tipo_empleado te ON e.id_tipo_empleado_fk = te.id_tipo_empleado_pk
                INNER JOIN tbl_tienda t ON e.id_tienda_fk = t.id_tienda_pk
                INNER JOIN tbl_usuario u ON e.id_usuario_fk = u.id_usuario_pk";
    
        $result = $this->conect->query($query);
        $empleados = [];
    
        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $empleados[] = $fila; 
            }
        }
    
        $this->desconectar();
        return $empleados;
    }
}
?>