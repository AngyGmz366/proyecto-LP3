<?php
require_once 'DAO/DAOCliente.php';
require_once 'DAO/DAOUsuario.php';

$daoUsuario = new DAOUsuario();

$usuario = new Usuario(); 


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de clientes - Rincon del Coleccionista</title>
    <link rel="stylesheet" href="./css/clientes.css">
</head>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <button onclick="window.location.href='homeEmpleados.php'">Volver</button>
    <script>
        function cargar(idUsuario, nombreTienda, correo, fechaRegistro, idCliente, membresia, idTienda){ 
            document.formulario1.id_usuario_pk.value = idUsuario;
            document.formulario1.nombre_tienda.value = nombreTienda;
            document.formulario1.correo.value = correo;
            document.formulario1.fecha_registro.value = fechaRegistro;
            document.formulario1.id_cliente_pk.value = idCliente; 
            document.formulario1.membresia.value = membresia; 
            document.formulario1.id_tienda_fk.value = idTienda; 
            document.getElementById("btnModificar").disabled = false;
            document.getElementById("btnEliminar").disabled = false;         
            document.formulario1.id_usuario_pk.readOnly = true;
        }

        function validar() {
            const form = document.getElementById("formulario1");
            const inputs = form.querySelectorAll("input");
            for (const input of inputs) {
                if (input.value === "") {
                    Swal.fire({title: "Error",text: "El campo " + input.id + " es obligatorio",icon: "error"});
                    return false;
                }
            }
            return true;
        }

        function validar2() {
            const form = document.getElementById("formulario2");
            const input = form.querySelector("input");
            if (input.value === "") {
                Swal.fire({title: "Error",text: "El campo buscar es obligatorio",icon: "error"});
                return false;
            }
            return true;
        }

        function recargar(){
            location.reload();
        }
    </script>   
</head>
<body>
    <section>
        <h2 style="position: relative; margin: auto; width: 500px;">Formulario de usuarios</h2>

        <form action="" method="post" name="formulario1" id="formulario1" onsubmit="return validar()" style="position: relative; margin: auto; width: 500px;">
            <div class="mb-3">
                
                <label for="id_usuario_pk">ID Usuario</label>
                <input type="number" class="form-control" id="id_usuario_pk" name="id_usuario_pk" min="1" step="1">

                <label for="nombre_tienda">Nombre</label>
                <input type="text" class="form-control" id="nombre_tienda" name="nombre_tienda" maxlength="100">

                <label for="correo">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" maxlength="100">

                <label for="fecha_registro">Fecha de registro</label>
                <input type="date" class="form-control" id="fecha_registro" name="fecha_registro">
            </div>
           
            <button type="submit" id="btnModificar" name="btnModificar" class="btn btn-danger" >Modificar</button>
            <button type="submit" id="btnEliminar" name="btnEliminar" class="btn btn-dark" >Eliminar</button>      
        </form>

        <br>
        <form action="" method="post" name="formulario2" id="formulario2" onsubmit="" style="position: relative; margin: auto; width: 500px;">
            <div class="mb-1">
                <label for="busqueda">Buscar: </label>
                <input type="text" class="form-control" id="buscar" name="buscar">                 
                <label for="criterio">Buscar por: </label>
                <table>
                    <tr>
                        <td>
                            <select class="form-select" id="criterio" name="criterio" style="width: 300px;">
                                <option value="id_usuario_pk">ID Usuario</option>
                                <option value="nombre_tienda">Nombre</option>
                                <option value="correo">Correo</option>
                                
                                <option value="id_cliente_pk">ID Cliente</option>  
                                
                            </select>
                        </td> 
                        <td>
                            <button type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-secondary" onclick="return validar2()">Buscar</button> 
                        </td>
                        <td>
                            </form>
                            <button type="submit" id="btnQuitarF" name="btnQuitarF" class="btn btn-success" onclick="return recargar()">Quitar filtro</button>
                        </td>
                    </tr>
                </table> 
            </div>
        </form>

        <?php
        $foot = "</section><section style='position: relative; margin: auto; width: 900px;'><br><br>";

        try {
            if(isset($_POST["btnModificar"])){
                $usuario->setIdUsuarioPk($_POST["id_usuario_pk"]);
                $usuario->setNombreTienda($_POST["nombre_tienda"]);
                $usuario->setCorreo($_POST["correo"]);
                $usuario->setFechaRegistro(new DateTime($_POST["fecha_registro"])); 
                $daoUsuario->actualizarUsuario($usuario);
                echo $foot.$daoUsuario->getTabla()."</section>";
                echo "<script>Swal.fire({title: 'Éxito', text: 'Usuario modificado correctamente', icon: 'success'});</script>";
            } elseif(isset($_POST["btnEliminar"])){
                $usuario->setIdUsuarioPk($_POST["id_usuario_pk"]);
                $daoUsuario->eliminarUsuario($usuario->getIdUsuarioPk());
                echo $foot.$daoUsuario->getTabla()."</section>";
                echo "<script>Swal.fire({title: 'Éxito', text: 'Usuario eliminado correctamente', icon: 'success'});</script>";
            } elseif(isset($_POST["btnBuscar"])){
                $v1 = $_POST["buscar"];
                $v2 = $_POST["criterio"];
                echo "</section><section style='position: relative; margin: auto; width: 900px;'><br><br>";
                echo $daoUsuario->filtrar($v1,$v2);
            } else {
                echo $foot.$daoUsuario->getTabla()."</section>"; 
            } 
        } catch (Exception $e) {
            echo "<script>Swal.fire({title: 'Error', text: '" . $e->getMessage() . "', icon: 'error'});</script>";
        }
        ?>
</body>
</html>