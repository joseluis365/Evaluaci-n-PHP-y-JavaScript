<?php
require_once("../database/connection.php");
$db = new database;
$con = $db-> conectar();
session_start();

if ($_POST["ingresar"]) {
    $doc = $_POST["documento"]; 
    $contra = htmlentities(addslashes($_POST["password"]));   
    $sql = $con ->prepare("SELECT * FROM pacientes WHERE doc = ?") ;
    $sql -> execute([$doc]);
    $fila = $sql -> fetch();

    if (password_verify($contra,$fila['contrasena'])){
        $_SESSION['doc'] = $fila ['doc'];
        $_SESSION['rol'] = $fila ['id_rol'];
        
        if ($_SESSION['rol']== 1) {
            header("location:../model/admin/index.php");
        }
        if ($_SESSION['rol']== 2) {
            header("location:../model/usuarios/index.php");
        }

    }

    else{
        echo '<script> alert("usuario no encontrado")</script>' ;
        echo '<script>window.location="../inicio.html"</script>';
    }

}
else{

}

?>
