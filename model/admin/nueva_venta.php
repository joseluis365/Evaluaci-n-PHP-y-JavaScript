<?php
    session_start();
    require_once("../../database/connection.php");
    $db = new database;
    $con = $db-> conectar();
    $doc = $_SESSION['doc'];

    $sql = $con -> prepare ( "SELECT * FROM usuario WHERE doc = '$doc'");
    $sql -> execute();
    $fila = $sql -> fetch();
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
    <title>Registro Venta - FerrMundial</title>
</head>
<body onload="centrar();">
    <div class="card2 p-4">
        <h3 class="text-center mb-3 title">Registrar venta</h3>
        <form id="form-venta">
        <div class="row">
            <div class=" mb-3">
                <label for="id_material" class="form-label"> Vendedor</label>
                <select class="ms-2 mb-5 form-select input" name="id_vendedor" id="id_vendedor" readonly>
                <option value="<?php echo $fila['doc']  ?>"><?php echo 'Administrador ' . $fila['nombre'] ?></option>
            </select>
            </div>
            <div class=" mb-3">
                <label for="nombre" class="form-label"> Comprador</label>
                <select class="ms-2 mb-5 form-select input" name="id_comprador" id="id_comprador" required>
                <option value="">Seleccione un Comprador</option>
                    <?php
                        $control = $con -> prepare (query: "SELECT * FROM usuario WHERE id_rol = 2");
                        $control -> execute();

                        while ($tp = $control->fetch(mode: PDO::FETCH_ASSOC))
                        {
                            echo "<option value=" . $tp['doc'] . ">" . $tp['nombre'] . "</option>";
                        }
                    ?>
            </select>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label"> Material</label>
                <select class="ms-2 mb-5 form-select input" name="id_material" id="id_material" required>
                <option value="">Seleccione un Material</option>
                    <?php
                        $control = $con -> prepare (query: "SELECT * FROM material");
                        $control -> execute();

                        while ($tp = $control->fetch(mode: PDO::FETCH_ASSOC))
                        {
                            echo "<option value=" . $tp['id_material'] . ">" . $tp['nombre_material'] . "</option>";
                        }
                    ?>
            </select>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label"> Valor Unitario</label>
                <select class="ms-2 mb-5 form-select input" name="valor" id="valor" required>
            </select>
            </div>
            <div>
                <label for="id_material" class="form-label"> Cantidad</label>
                <input class="ms-2 mb-5 form-select input" type="number" id="cantidad" name="cantidad" placeholder="Cantidad de la venta" required>
            </div>
            <br>
            <br>
            <div class="d-grid d-flex justify-content-center" >
            <button type="submit" class="btn btn-custom2" style="width: 50%;">Realizar Venta</button>
            </div>
        </form>
    </div>

    <script>
        const formVenta = document.getElementById('form-venta');
        formVenta.addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData();
            formData.append('id_material', document.getElementById('id_vendedor').value);
            formData.append('id_comprador', document.getElementById('id_comprador').value);
            formData.append('id_material', document.getElementById('id_material').value);
            formData.append('valor', document.getElementById('valor').value);
            formData.append('cantidad', document.getElementById('cantidad').value);
            try {
                const response = await fetch('crud_venta.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                
                if(data.message){
                    alert(data.message);
                    formVenta.reset();
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        recargarLista();

        $('#id_material').change(function(){
            recargarLista();
        });
    });

    function recargarLista(){
        $.ajax({
            type: "POST",
            url: "valores.php",
            data: "id_material=" + $('#id_material').val(),
            success: function(r){
                $('#valor').html(r)
            }
        });
    }
</script>
</body>
</html>