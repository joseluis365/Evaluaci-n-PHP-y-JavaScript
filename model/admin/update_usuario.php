<?php
session_start();
require_once("../../database/connection.php");
$db = new database;
$con = $db-> conectar();

$doc = $_GET['doc'];
$sql = $con->prepare("SELECT * FROM usuario INNER JOIN rol ON usuario.id_rol = rol.id_rol WHERE doc = ?");
$sql->execute([$doc]);
$resultado = $sql->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <script>
        function centrar() {
            iz=(screen.width-document.body.clientWidth) / 2;
            de=(screen.height-document.body.clientHeight) / 2;
            moveTo(iz,de);
        }

        async function enviarFormulario(e,accion){
            e.preventDefault();
            const datos = new FormData(document.getElementById('form-usuario'));
            datos.append('accion', accion);
            try{
                const resp = await fetch('../../usuario_crud.php',{method:'POST',body:datos});
                const json = await resp.json();
                alert(json.message || json.error || 'Operación completada');
                if(!json.error){ window.close(); }
            }catch(error){ console.error(error);
            alert('Error: '+ error); }
        }
    </script>
<head>
    <meta charset="utf-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../../controller/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body onload="centrar();">
    <h1 class="mx-3">Datos del Usuario</h1>
    <div class="mx-3">
        <table>
        <form method="POST" id="form-usuario" autocomplete="off">
            <tr>
                <td>Documento</td>
                <td><input class="form-control" type="number" name="documento" id="documento" value="<?php echo $resultado['doc']; ?>" readonly></td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td><input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $resultado['nombre']; ?>" required></td>
            </tr>
            <tr>
                <td>Teléfono</td>
                <td><input class="form-control" type="text" name="telefono" id="telefono" value="<?php echo $resultado['telefono']; ?>" required></td>
            </tr>
            <tr>
                <td>Dirección</td>
                <td><input class="form-control" type="text" name="direccion" id="direccion" value="<?php echo $resultado['direccion']; ?>" required></td>
            </tr>
            <tr>
                <td>Correo</td>
                <td><input class="form-control" type="email" name="email" id="email" value="<?php echo $resultado['email']; ?>" required></td>
            </tr>
            <tr>
                <td>Rol</td>
                <td>
                    <select class="form-select" name="id_rol" id="id_rol">
                        <option value="<?php echo $resultado['id_rol']; ?>"><?php echo $resultado['rol']; ?></option>
                        <?php
                        $roles = $con->query("SELECT * FROM rol");
                        while ($r = $roles->fetch(PDO::FETCH_ASSOC)){
                            if($r['id_rol'] != $resultado['id_rol']){
                                echo "<option value='".$r['id_rol']."'>".$r['rol']."</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><button class="btn btn-primary my-3 mx-1" onclick="enviarFormulario(event,'update')">Actualizar Datos</button></td>
                <td><button class="btn btn-danger my-3" onclick="enviarFormulario(event,'delete')">Eliminar</button></td>
            </tr>
        </form>
        </table>
    </div>
</body>
</html>

