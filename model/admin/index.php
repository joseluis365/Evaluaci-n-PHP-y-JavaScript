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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="busqueda.js"></script>
    <link rel="icon" type="image/x-icon" href="../../controller/image/logos.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../controller/css/style.css">
    <title>Modulo de Administración - FerrMundial</title>
</head>
<body class="body2">
      <header class="header d-flex justify-content-between align-items-center">
        <div class="d-flex">
        <img src="../../controller/image/logos.png" alt="Logo MediRegistro" class="logo">
          <div class="title">
            <h2 class="m-0">FerrMundial</h2>
            <p class="m-0">Productos de calidad a un click</p>
          </div>
        </div>
          <form class="cerrar-sesion" method="POST">
          <button class="btn btn-light boton-cerrar" type="submit" name="cerrar_sesion">Cerrar Sesion</button>
    </form>
    </header>
        <div class="container-navbar d-flex">
      <!-- Sidebar -->
      <div class="menu bg-dark text-white sidebar pt-2   vh-100">
        <h4 class="mb-4 texto px-3 py-3">Menú</h4>
        <ul class="nav flex-column">
          <li class="nav-item py-1 fs-5 activo">
            <a href="" class="nav-link text-white">Usuarios</a>
          </li>
          <li class="nav-item py-2 fs-5">
            <a href="materiales.php" class="nav-link text-white">Materiales</a>
          </li>
          <li class="nav-item py-2 fs-5">
            <a href="ventas.php" class="nav-link text-white">Ventas</a>
          </li>
          <li class="nav-item py-2 fs-5">
            <a href="roles.php" class="nav-link text-white">Roles</a>
          </li>
        </ul>
      </div>

      <!-- Contenido -->
      <div class="flex-grow-1 p-3">
        <h1>Módulo de Administración - Usuarios</h1>
      
      <section>
        <div class="d-flex">
        <div class="mx-0 d-block mt-5">
                <label class="ml-3 search" for="caja-busqueda">Buscar: </label>
                <input class="input-search" style="width: 300px; border-radius: 5px; border: solid 1px;" type="text" name="caja-busqueda" id="caja-busqueda" placeholder="Nombre o Documento">
        </div>
        <div class="mt-5 ms-5">
        <a href="" onclick="window.open('registro_usuario.php','','width= 700,height=800, toolbar=NO'); 
                        void(null);"><button class="btn btn-danger">Nuevo Usuario</button></a>
        </div>
        </div>
        <br>
        <div class="col-11 m-0 ">
        <div id="datos"> </div>
        </div>
    </section>
    
    </div>
    </div>
</body>
</html>