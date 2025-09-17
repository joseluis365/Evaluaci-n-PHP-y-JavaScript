<?php
session_start();
$host   = "localhost";
$usuario= "root";
$clave  = "";
$dataBase   = "evaluacion-ferreteria";
$puerto = 33065;

$con = new mysqli($host, $usuario, $clave, $dataBase, $puerto);

// Verificar conexión
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

$tipo      = $_FILES['archivo_excel']['type'];
$tamanio   = $_FILES['archivo_excel']['size'];
$archivoTmp= $_FILES['archivo_excel']['tmp_name'];
$lineas    = file($archivoTmp);

$i = 0;

foreach ($lineas as $linea) {
    $cantidadRegistros          = count($lineas);
    $cantidadRegistrosAgregados = $cantidadRegistros - 1;

    $doc = $nombre = $telefono = $email = $direccion = $contrasena = $fecha_registro = $id_rol = '';
    $cant_duplicidad = 0;

    if ($i != 0) {
        $datos = explode(",", trim($linea));

        $doc          = !empty($datos[0]) ? $datos[0] : '';
        $nombre      = !empty($datos[1]) ? $datos[1] : '';
        $telefono = !empty($datos[2]) ? $datos[2] : '';
        $email  = !empty($datos[3]) ? $datos[3] : '';
        $direccion    = !empty($datos[4]) ? $datos[4] : '';
        $contrasena = !empty($datos[5]) ? $datos[5] : '';
        $fecha_registro   = !empty($datos[6]) ? $datos[6] : '';
        $id_rol   = !empty($datos[7]) ? $datos[7] : '';
        $PASS_ENCRIP = password_hash($contrasena, PASSWORD_DEFAULT);
    }

    if (!empty($doc)) {
        $checkIdDuplicate = "SELECT doc FROM usuario WHERE doc ='$doc'";
        $ca_dupli         = mysqli_query($con, $checkIdDuplicate);
        $cant_duplicidad  = mysqli_num_rows($ca_dupli);
    }

    if (!empty($doc) && $cant_duplicidad == 0) {
        $insertarData = "INSERT INTO usuario 
            (doc, nombre, telefono, email, direccion, contrasena, fecha_registro, id_rol) 
            VALUES ('$doc', '$nombre', '$telefono', '$email', '$direccion', '$PASS_ENCRIP', '$fecha_registro', '$id_rol')";
        mysqli_query($con, $insertarData);
    } elseif (!empty($id)) {
        $updateData = "UPDATE usuario SET 
                nombre      = '$nombre',
                telefono = '$telefono',
                email   = '$email',
                direccion    = '$direccion',
                contrasena = '$PASS_ENCRIP',
                fecha_registro = '$fecha_registro'
                id_rol = '$id_rol'
            WHERE id_enfermedad = '$doc'";
        mysqli_query($con, $updateData);
        
    }

    $i++;
}
echo '<script> alert("Datos Registrados Exitosamente")</script>' ;
echo '<script>window.location="index.php"</script>';
$con->close();
?>


