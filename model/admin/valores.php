<?php
require_once("../../database/connection.php");
$db = new database;
$con = $db-> conectar();

if (isset($_POST['id_material'])) {
    $id_material = $_POST['id_material'];

    $sql = $con->prepare("SELECT valor_unitario FROM material WHERE id_material = $id_material");
    $sql->execute();
    $razas = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo "<option value='' disabled>Valor Unitario del Producto</option>";
    foreach ($razas as $r) {
        echo "<option value='".$r['valor_unitario']."'>".$r['valor_unitario']."</option>";
    }
}
?>