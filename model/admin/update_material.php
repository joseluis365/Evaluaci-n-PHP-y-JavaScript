<?php 
session_start();
require_once("../../database/connection.php");
$db = new database;
$con = $db->conectar();

$id = $_GET['id'];

$sql = $con->prepare(
    "SELECT * from material WHERE id_material = ?"
);
$sql->execute([$id]);
$resultado = $sql->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<script>
    function centrar() {
        iz=(screen.width-document.body.clientWidth)/2;
        de=(screen.height-document.body.clientHeight)/2;
        moveTo(iz,de);
    }
    async function enviarFormulario(e,accion){
        e.preventDefault();
        const datos = new FormData(document.getElementById('form-material'));
        datos.append('accion', accion);
        try{
            const resp = await fetch('crud_material.php',{method:'POST',body:datos});
            const json = await resp.json();
            alert(json.message || json.error || 'Operación completada');
            if(!json.error){ window.close(); }
        }catch(err){ alert('Error: '+err); }
    }
</script>
<head>
    <meta charset="utf-8">
    <title>Editar Material</title>
    <link rel="stylesheet" href="../../controller/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body onload="centrar();">
<h1 class="mx-3">Editar Material</h1>
<div class="mx-3">
<form method="POST" id="form-material" autocomplete="off">
<table>
    <tr>
        <td>ID Material</td>
        <td><input class="form-control" type="number" name="id_material" id="id_material" value="<?php echo $resultado['id_material']; ?>" readonly></td>
    </tr>
    <tr>
        <td>Nombre</td>
        <td><input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $resultado['nombre_material']; ?>" required></td>
    </tr>
    <tr>
        <td>Valor Unitario</td>
        <td><input class="form-control" type="text" name="valor" id="valor" value="<?php echo $resultado['valor_unitario']; ?>" required></td>
    </tr>
    <tr>
        <td><button class="btn btn-primary my-3 mx-1" 
            onclick="enviarFormulario(event,'update')">Actualizar Datos</button></td>
        <td><button class="btn btn-danger my-3" 
            onclick="enviarFormulario(event,'delete')">Eliminar</button></td>
    </tr>
</table>
</form>
</div>
</body>
</html>

