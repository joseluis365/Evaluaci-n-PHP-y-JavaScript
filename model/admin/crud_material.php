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
            $id = trim($_POST['id_material']);
            $nombre = trim($_POST['nombre']);
            $valor = trim($_POST['valor']);

            $sql = $pdo->prepare("INSERT INTO material 
                (id_material, nombre_material, valor_unitario) 
                VALUES (?, ?, ?)");
            $sql->execute([
                $id,
                $nombre,
                $valor
            ]);

            echo json_encode(['message' => 'Material registrado correctamente.']);
            exit;
        }

        //ACTUALIZAR
        if ($accion === 'update') {
            $id = trim($_POST['id_material']); 
            $nombre = trim($_POST['nombre']);
            $valor = trim($_POST['valor']);


            $sql = "UPDATE material
                    SET nombre_material = ?, valor_unitario = ? 
                    WHERE id_material = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $nombre,
                $valor,
                $id
            ]);

            echo json_encode(['message' => 'Material Actualizado correctamente.']);
            exit;
        }

        //ELIMINAR
        if ($accion === 'delete') {
            $id = trim($_POST['id']);
            $sql = $pdo->prepare("DELETE FROM material WHERE id_material = ?");
            $sql->execute([$id]);
            echo json_encode(['message' => 'Material eliminado correctamente.']);
            exit;
        }

        echo json_encode(['error' => 'Acción no reconocida.']);
    } else {
        echo json_encode(['error' => 'Método no permitido.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}
