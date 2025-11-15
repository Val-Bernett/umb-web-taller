<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

require_once __DIR__ . '/modelo.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?? [];

switch ($method) {
    case 'GET':
        echo json_encode(obtenerTareas());
        break;
    case 'POST':
        $titulo = isset($input['titulo']) ? trim($input['titulo']) : '';
        if ($titulo === '') {
            http_response_code(422);
            echo json_encode(['mensaje' => 'Título requerido']);
            break;
        }
        $id = crearTarea($titulo);
        echo json_encode(['id' => $id, 'mensaje' => 'Tarea creada']);
        break;
    case 'PUT':
        $id = isset($input['id']) ? (int) $input['id'] : 0;
        if ($id <= 0) {
            http_response_code(422);
            echo json_encode(['mensaje' => 'ID inválido']);
            break;
        }
        $titulo = array_key_exists('titulo', $input) ? $input['titulo'] : null;
        $comp = array_key_exists('completada', $input) ? ($input['completada'] ? 1 : 0) : null;
        $ok = actualizarTarea($id, $titulo, $comp);
        echo json_encode(['ok' => $ok]);
        break;
    case 'DELETE':
        $id = isset($input['id']) ? (int) $input['id'] : 0;
        if ($id <= 0) {
            http_response_code(422);
            echo json_encode(['mensaje' => 'ID inválido']);
            break;
        }
        $ok = eliminarTarea($id);
        echo json_encode(['ok' => $ok]);
        break;
    default:
        http_response_code(405);
        echo json_encode(['mensaje' => 'Método no permitido']);
}
?>