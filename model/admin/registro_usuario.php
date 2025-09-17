<?php
    session_start();
    require_once("../../database/connection.php");
    $db = new database;
    $con = $db-> conectar();
?>



<?php
if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("location:../../index.html");
} 
?>

<!DOCTYPE html>
<html lang="es">
    <script>
        function centrar() {
            iz=(screen.width-document.body.clientWidth) / 2;
            de=(screen.height-document.body.clientHeight) / 2;
            moveTo(iz,de);
        }
    </script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../controller/css/style.css">
    <title>Registro - FerrMundial</title>
</head>
<body onload="centrar();">
    <div class="card2 p-4">
        <h3 class="text-center mb-3 title">Registrar Usuario</h3>
        <form id="form-registro" enctype="multipart/form-data">
        <div class="row">
            <div class=" mb-3">
                <label for="documento" class="form-label"><i class="icono bi bi-person-vcard"></i> Documento</label>
                <input type="number" class="form-control input" id="documento" name="documento" placeholder="Ingrese su documento" required>
            </div>
            <div class=" mb-3">
                <label for="nombre" class="form-label"><i class="bi bi-person-lines-fill"></i> Nombre</label>
                <input type="text" class="form-control input" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
            </div>
            <div class=" mb-3">
                <label for="telefono" class="form-label"><i class="bi bi-telephone-plus"></i> Teléfono</label>
                <input type="number" class="form-control input" id="telefono" name="telefono" placeholder="Ingrese su teléfono" required>
            </div>
            <div class=" mb-3">
                <label for="direccion" class="form-label"><i class="bi bi-house-add"></i> Dirección</label>
                <input type="text" class="form-control input" id="direccion" name="direccion" placeholder="Ingrese su dirección" required>
            </div>
            <div class=" mb-3">
                <label for="email" class="form-label"><i class="bi bi-envelope-at"></i> Email</label>
                <input type="email" class="form-control input" id="email" name="email" placeholder="Ingrese su email" required>
            </div>
            <div class=" mb-3">
                <label for="password" class="form-label"><i class="bi bi-key"></i> Contraseña</label>
                <input type="password" class="form-control input" id="password" name="password" placeholder="Ingrese su contraseña" required>
            </div>
            </div>
            <br>
            <div class="d-grid d-flex justify-content-center" >
            <button type="submit" class="btn btn-custom2" style="width: 50%;">Registrar</button>
            </div>
        </form>
    </div>

    <script>
        const formRegistro = document.getElementById('form-registro');
        formRegistro.addEventListener('submit', async function(event) {
            event.preventDefault(); 
            const formData = new FormData();
            formData.append('action', 'create');
            formData.append('documento', document.getElementById('documento').value);
            formData.append('nombre', document.getElementById('nombre').value);
            formData.append('telefono', document.getElementById('telefono').value);
            formData.append('direccion', document.getElementById('direccion').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('password', document.getElementById('password').value);

            try {
                const response = await fetch('../../usuario_crud.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                
                if(data.message){
                    alert(data.message);
                    formRegistro.reset();
                    window.close(); 
                } else if(data.error){
                    alert('Error: ' + data.error);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al Conectar con el Servidor');
            }
        });
    </script>
</body>
</html>