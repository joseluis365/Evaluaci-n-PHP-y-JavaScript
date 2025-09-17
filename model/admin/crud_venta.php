<?php
header('Content-Type: application/json; charset=utf-8');
$host = 'localhost';
$dbname = 'evaluacion-ferreteria';
$username = 'root';
$password = '';
$port = 33065;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $accion = $_POST['accion'] ?? 'create'; 

        //CREAR
        if ($accion === 'create') {
            $id_vendedor = trim($_POST['id_vendedor']);
            $id_comprador = trim($_POST['id_comprador']);
            $id_material = trim($_POST['id_material']);
            $valor = trim($_POST['valor']);
            $cantidad = trim($_POST['cantidad']);
            $total = $valor * $cantidad;

            $sql = $pdo->prepare("INSERT INTO venta 
                (doc_vendedor, doc_comprador, id_material, cantidad_venta, total) 
                VALUES (?, ?, ?)");
            $sql->execute([
                $id_vendedor,
                $id_comprador,
                $id_material,
                $cantidad,
                $total
            ]);

            echo json_encode(['message' => 'Venta registrada correctamente.']);
            exit;
        }

        echo json_encode(['error' => 'Acción no reconocida.']);
    } else {
        echo json_encode(['error' => 'Método no permitido.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}
