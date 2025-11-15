<?php
require_once __DIR__ . '/db.php';

function crearTarea(string $titulo): int {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO tareas (titulo) VALUES (:titulo)');
    $stmt->execute([':titulo' => $titulo]);
    return (int) $pdo->lastInsertId();
}

function obtenerTareas(): array {
    global $pdo;
    $stmt = $pdo->query('SELECT id, titulo, completada FROM tareas ORDER BY id DESC');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function actualizarTarea(int $id, ?string $titulo, ?int $completada): bool {
    global $pdo;
    $fields = [];
    $params = [':id' => $id];
    if ($titulo !== null) {
        $fields[] = 'titulo = :titulo';
        $params[':titulo'] = $titulo;
    }
    if ($completada !== null) {
        $fields[] = 'completada = :completada';
        $params[':completada'] = $completada ? 1 : 0;
    }
    if (!$fields) {
        return false;
    }
    $sql = 'UPDATE tareas SET ' . implode(', ', $fields) . ' WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

function eliminarTarea(int $id): bool {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM tareas WHERE id = :id');
    return $stmt->execute([':id' => $id]);
}
?>