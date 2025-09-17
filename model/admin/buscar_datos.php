<?php
    session_start();
    require_once("../../database/connection.php");
    $db = new database;
    $con = $db-> conectar();

$mysqli = new mysqli("localhost", "root", "", "evaluacion-ferreteria","33065");


$salida = "";

$query = "SELECT * FROM usuario INNER JOIN rol ON usuario.id_rol = rol.id_rol ORDER BY usuario.doc ";

if(isset($_POST['consulta'])){
    $q = $mysqli -> real_escape_string($_POST['consulta']);
    $query = "SELECT * FROM usuario INNER JOIN rol ON usuario.id_rol = rol.id_rol WHERE usuario.nombre LIKE '%".$q."%' 
                OR usuario.doc LIKE '%".$q."%' ORDER BY usuario.doc 
                ";
}
$resul = $mysqli ->query($query);
if($resul ->num_rows > 0){
    $salida.="<br><br> <form  method='GET'>
            <table class=' table table-bordered '>
                <thead class='table-danger text-white'>
                    <tr class='#'>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Direccion</th>
                        <th class='col-2'>Correo</th>
                        <th>ROL</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>";

    while($fila = $resul->fetch_assoc()){
        $salida.="<tr >
    <td align='center'>" . $fila['doc'] . "</td>
    <td align='center'>" . $fila['nombre'] . "</td>
    <td align='center'>" . $fila['telefono']. "</td>
    <td align='center'>" . $fila['direccion']. "</td>
    <td align='center'>" . $fila['email']. "</td>
    <td align='center'>" . $fila['rol']. "</td>
    <td>
<a href=\"javascript:void(0);\" 
    onclick=\"window.open('update_usuario.php?doc=".$fila['doc']."','','width=700,height=500,toolbar=no');\">
    <button type='button' class='btn btn-warning mx-3'>Editar/Eliminar</button>
</a>
</td>
</tr>";
    }
    $salida.="</tbody></table>";
} else {
    $salida.="No hay datos";
}

echo $salida;
$mysqli->close();
?>