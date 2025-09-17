<?php
    session_start();
    require_once("../../database/connection.php");
    $db = new database;
    $con = $db-> conectar();
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
    <title>Registro Material - FerrMundial</title>
</head>
<body onload="centrar();">
    <div class="card2 p-4">
        <h3 class="text-center mb-3 title">Registrar Material</h3>
        <form id="form-material">
        <div class="row">
            <div class=" mb-3">
                <label for="id_material" class="form-label"> ID</label>
                <input type="text" class="form-control input" id="id_material" name="id_material" placeholder="Ingrese el ID del Material" required>
            </div>
            <div class=" mb-3">
                <label for="nombre" class="form-label"> Nombre</label>
                <input type="text" class="form-control input" id="nombre" name="nombre" placeholder="Ingrese el nombre del Material" required>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label"> Valor Unitario</label>
                <input type="text" class="form-control input" id="valor" name="valor" placeholder="Ingrese el valor sin puntos ni comas" required>
            </div>
            <br>
            <br>
            <div class="d-grid d-flex justify-content-center" >
            <button type="submit" class="btn btn-custom2" style="width: 50%;">Agregar</button>
            </div>
        </form>
    </div>

    <script>
        const formMaterial = document.getElementById('form-material');
        formMaterial.addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData();
            formData.append('id_material', document.getElementById('id_material').value);
            formData.append('nombre', document.getElementById('nombre').value);
            formData.append('valor', document.getElementById('valor').value);
            try {
                const response = await fetch('crud_material.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                
                if(data.message){
                    alert(data.message);
                    formMaterial.reset();
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