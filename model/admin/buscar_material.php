<?php
    session_start();
    require_once("../../database/connection.php");
    $db = new database;
    $con = $db-> conectar();

$mysqli = new mysqli("localhost", "root", "", "evaluacion-ferreteria","33065");


$salida = "";

$query = "SELECT * FROM material ORDER BY material.id_material";

if(isset($_POST['consulta'])){
    $q = $mysqli -> real_escape_string($_POST['consulta']);
    $query = "SELECT * FROM material WHERE material.nombre_material LIKE '%".$q."%' 
                OR material.id_material LIKE '%".$q."%' ORDER BY material.id_material 
                ";
}
$resul = $mysqli ->query($query);
if($resul ->num_rows > 0){
    $salida.="<br><br> <form  method='GET'>
            <table class=' table table-bordered '>
                <thead class='table-danger text-white'>
                    <tr class='#'>
                        <th>ID Material</th>
                        <th>Nombre</th>
                        <th>Valor Unitario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>";

    while($fila = $resul->fetch_assoc()){
        $salida.="<tr >
    <td align='center'>" . $fila['id_material'] . "</td>
    <td align='center'>" . $fila['nombre_material'] . "</td>
    <td align='center'>". '$' . number_format($fila['valor_unitario'], 0, ',', '.') . ' COP' .  "</td>
    <td>
<a href=\"javascript:void(0);\" 
    onclick=\"window.open('update_material.php?id=".$fila['id_material']."','','width=700,height=500,toolbar=no');\">
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