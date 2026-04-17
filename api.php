<?php
// Configuración de cabeceras para que sea una API JSON
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Cambia estas variables al principio de tu archivo
$host = "localhost";
$port = "3307"; // <--- Agregamos el puerto que se ve en tu phpMyAdmin
$db_name = "grupo 5a";
$username = "root";
$password = ""; // Si te sigue dando error, intenta poner 'root' aquí también

try {
    // La cadena de conexión debe incluir el puerto así:
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

// 2. Obtener el método de la petición y el ID (si existe en la URL)
$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// 3. Lógica del CRUD
switch ($method) {
    
    // OPERACIÓN: LEER (GET)
    case 'GET':
        if ($id) {
            $stmt = $conn->prepare("SELECT * FROM alumnos WHERE id = ?");
            $stmt->execute([$id]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $conn->prepare("SELECT * FROM alumnos");
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($resultado);
        break;

    // OPERACIÓN: CREAR (POST)
    case 'POST':
        $datos = json_decode(file_get_contents("php://input"), true);
        if (!empty($datos['nombre'])) {
            $sql = "INSERT INTO alumnos (nombre, edad, correo, escuela) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$datos['nombre'], $datos['edad'], $datos['correo'], $datos['escuela']]);
            echo json_encode(["mensaje" => "Alumno creado con éxito", "id" => $conn->lastInsertId()]);
        } else {
            echo json_encode(["error" => "Datos incompletos"]);
        }
        break;

    // OPERACIÓN: ACTUALIZAR (PUT)
    case 'PUT':
        $datos = json_decode(file_get_contents("php://input"), true);
        if ($id && !empty($datos['nombre'])) {
            $sql = "UPDATE alumnos SET nombre=?, edad=?, correo=?, escuela=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$datos['nombre'], $datos['edad'], $datos['correo'], $datos['escuela'], $id]);
            echo json_encode(["mensaje" => "Alumno actualizado con éxito"]);
        } else {
            echo json_encode(["error" => "ID o datos faltantes"]);
        }
        break;

    // OPERACIÓN: ELIMINAR (DELETE)
    case 'DELETE':
        if ($id) {
            $stmt = $conn->prepare("DELETE FROM alumnos WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(["mensaje" => "Alumno eliminado con éxito"]);
        } else {
            echo json_encode(["error" => "ID no proporcionado"]);
        }
        break;

    default:
        echo json_encode(["mensaje" => "Método no soportado"]);
        break;
}
?>