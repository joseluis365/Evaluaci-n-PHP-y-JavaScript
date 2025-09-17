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

        // --- Acción que determina qué hacer ---
        $accion = $_POST['accion'] ?? 'create';

        // ---------- ACTUALIZAR ----------
        if ($accion === 'update') {
            $doc = trim($_POST['documento']);
            $nombre = trim($_POST['nombre']);
            $sexo = trim($_POST['sexo']);
            $telefono = trim($_POST['telefono']);
            $direccion = trim($_POST['direccion']);
            $email = trim($_POST['email']);
            $fecha_nacimiento = trim($_POST['fecha_nacimiento']);

            // Si se envía una nueva foto
            $imagen = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
                $fileTmpPath = $_FILES['foto']['tmp_name'];
                $fileName = $_FILES['foto']['name'];
                $fileSize = $_FILES['foto']['size'];
                $fileType = $_FILES['foto']['type'];

                $allowedTypes = ['image/png', 'image/jpg'];
                if (!in_array($fileType, $allowedTypes)){
                    die(json_encode(['error' => 'Solo se Permiten Archivos JPG y PNG.']));
                }

                if($fileSize > 200 * 1024) {
                    die(json_encode(['error' => 'El archivo no debe superar los 200 KB.']));
                }

                $uploadDir = 'controller/image/fotos/';
                if (!is_dir($uploadDir)){
                    mkdir($uploadDir, 0777, true);
                }
                $newFileName = uniqid() . '_' . $fileName;
                $destPath = $uploadDir . $newFileName;

                if (!move_uploaded_file($fileTmpPath, $destPath)){
                    die(json_encode(['error' => 'Error al subir la imagen.']));
                }
                $imagen = $destPath;
            }

            $params = [
                $nombre,
                $sexo,
                $telefono,
                $direccion,
                $email,
                $fecha_nacimiento,
                $doc
            ];

            $setFoto = '';
            if ($imagen) {
                $setFoto = ", foto = ?";
                array_splice($params, 5, 0, $imagen);
            }
            $sql = "UPDATE pacientes 
                    SET nombre = ?, sexo = ?, telefono = ?, direccion = ?, email = ? $setFoto , fech_naci = ?
                    WHERE doc = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            echo json_encode(['message' => 'Paciente actualizado correctamente.']);
            
            exit;
        }

        // ---------- ELIMINAR ----------
        if ($accion === 'delete') {
            $doc = trim($_POST['documento']);
            $sql = $pdo->prepare("DELETE FROM pacientes WHERE doc = ?");
            $sql->execute([$doc]);
            echo json_encode(['message' => 'Paciente eliminado correctamente.']);
            exit;
        }

        // ---------- REGISTRAR (igual a tu original) ----------
        if ($accion === 'create') {
            $doc = trim($_POST['documento']);
            $nombre = trim($_POST['nombre']);
            $sexo = trim($_POST['sexo']);
            $telefono = trim($_POST['telefono']);
            $direccion = trim($_POST['direccion']);
            $email = trim($_POST['email']);
            $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
            $password = trim($_POST['password']);

            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
                $fileTmpPath = $_FILES['foto']['tmp_name'];
                $fileName = $_FILES['foto']['name'];
                $fileSize = $_FILES['foto']['size'];
                $fileType = $_FILES['foto']['type'];

                $allowedTypes = ['image/png', 'image/jpg'];
                if (!in_array($fileType, $allowedTypes)){
                    die(json_encode(['error' => 'Solo se Permiten Archivos JPG y PNG.']));
                }

                if($fileSize > 200 * 1024) {
                    die(json_encode(['error' => 'El archivo no debe superar los 200 KB.']));
                }

                $uploadDir = 'controller/image/fotos/';
                if (!is_dir($uploadDir)){
                    mkdir($uploadDir, 0777, true);
                }
                $newFileName = uniqid() . '_' . $fileName;
                $destPath = $uploadDir . $newFileName;

                if (!move_uploaded_file($fileTmpPath, $destPath)){
                    die(json_encode(['error' => 'Error al subir la imagen.']));
                }

                $imagen = $destPath;
                $PASS_ENCRIP = password_hash($password,PASSWORD_DEFAULT);

                $sql = $pdo->prepare("INSERT INTO pacientes 
                    (doc, nombre, sexo, telefono, direccion, email, foto, contrasena, fech_naci, id_rol) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 2)");
                $sql->execute([$doc, $nombre, $sexo, $telefono, $direccion, $email, $imagen, $PASS_ENCRIP, $fecha_nacimiento]);

                echo json_encode(['message' => 'Datos guardados correctamente.']);
                echo '<script>window.location="inicio.html"</script>';
                exit;
            } else {
                echo json_encode(['error' => 'Error al subir la imagen.']);
                exit;
            }
        }

        echo json_encode(['error' => 'Acción no reconocida.']);
    } else {
        echo json_encode(['error' => 'Método no permitido.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}