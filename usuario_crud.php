<?php
header('Content-Type: application/json; charset=utf-8');

$host     = 'localhost';
$dbname   = 'evaluacion-ferreteria';
$username = 'root';
$password = '';
$port     = 33065;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accion = $_POST['accion'] ?? 'create';

        //ACTUALIZAR
        if ($accion === 'update') {
            $doc = trim($_POST['documento']);
            $nombre = trim($_POST['nombre']);
            $telefono = trim($_POST['telefono']);
            $direccion = trim($_POST['direccion']);
            $email = trim($_POST['email']);
            $rol = trim($_POST['id_rol']);

            $sql = "UPDATE usuario
                    SET nombre = ?, telefono = ?, direccion = ?, email = ?, id_rol = ? 
                    WHERE doc = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $telefono, $direccion, $email, $rol, $doc]);

            echo json_encode(['message' => 'Usuario actualizado correctamente.']);
            exit;

        //ELIMINAR
        } elseif ($accion === 'delete') {
            $doc = trim($_POST['documento']);
            $sql = $pdo->prepare("DELETE FROM usuario WHERE doc = ?");
            $sql->execute([$doc]);

            echo json_encode(['message' => 'Usuario eliminado correctamente.']);
            exit;

        //CREAR
        } elseif ($accion === 'create') {
            $doc = trim($_POST['documento']);
            $nombre = trim($_POST['nombre']);
            $telefono = trim($_POST['telefono']);
            $direccion = trim($_POST['direccion']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $PASS_ENCRIP = password_hash($password, PASSWORD_DEFAULT);

            $sql = $pdo->prepare(
                "INSERT INTO usuario (doc, nombre, telefono, direccion, email, contrasena, id_rol)
                VALUES (?, ?, ?, ?, ?, ?, 2)"
            );
            $sql->execute([$doc, $nombre, $telefono, $direccion, $email, $PASS_ENCRIP]);

            echo json_encode(['message' => 'Datos guardados correctamente.']);
            exit;

        } else {
            echo json_encode(['error' => 'Acción no válida.']);
            exit;
        }

    } else {
        echo json_encode(['error' => 'Método no permitido.']);
        exit;
    }

} catch (Exception $e) {

    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
    exit;
}
?>
