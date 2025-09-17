<?php
    session_start();
    require_once("../../database/connection.php");
    $db = new database;
    $con = $db-> conectar();

$mysqli = new mysqli("localhost", "root", "", "evaluacion-ferreteria","33065");


$salida = "";

$query = "SELECT v.nombre AS vendedor, c.doc AS doc, c.nombre AS comprador, c.telefono AS telefono, ve.fecha_venta, m.id_material, m.nombre_material, ve.cantidad_venta, m.valor_unitario, ve.total
            FROM venta AS ve
            JOIN usuario AS v   ON ve.doc_vendedor  = v.doc 
            JOIN usuario AS c   ON ve.doc_comprador = c.doc 
            JOIN material AS m  ON ve.id_material   = m.id_material;";

if(isset($_POST['consulta'])){
    $q = $mysqli -> real_escape_string($_POST['consulta']);
    $query = "SELECT * FROM venta WHERE venta.id_venta LIKE '%".$q."%' 
                OR venta.doc_vendedor LIKE '%".$q."%' ORDER BY venta.id_venta
                ";
}
$resul = $mysqli ->query($query);
if($resul ->num_rows > 0){
    $salida.="<br><br> <form  method='GET'>
            <table class=' table table-bordered '>
                <thead class='table-danger text-white'>
                    <tr class='#'>
                        <th>Vendedor</th>
                        <th>Documento Comprador</th>
                        <th>Nombre Comprador</th>
                        <th>Telefono</th>
                        <th>Fecha Venta</th>
                        <th>ID Material</th>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Valor Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>";

    while($fila = $resul->fetch_assoc()){
        $salida.="<tr >
    <td align='center'>" . $fila['vendedor'] . "</td>
    <td align='center'>" . $fila['doc'] . "</td>
    <td align='center'>" . $fila['comprador'] . "</td>
    <td align='center'>" . $fila['telefono'] . "</td>
    <td align='center'>" . $fila['fecha_venta'] . "</td>
    <td align='center'>" . $fila['id_material'] . "</td>
    <td align='center'>" . $fila['nombre_material'] . "</td>
    <td align='center'>" . $fila['cantidad_venta'] . "</td>
    <td align='center'>". '$' . number_format($fila['valor_unitario'], 0, ',', '.') . ' COP' .  "</td>
    <td align='center'>". '$' . number_format($fila['total'], 0, ',', '.') . ' COP' .  "</td>
    
</tr>";
    }
    $salida.="</tbody></table>";
} else {
    $salida.="No hay datos";
}

echo $salida;
$mysqli->close();
?>