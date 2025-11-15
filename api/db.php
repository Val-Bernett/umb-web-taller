<?php
$baseDir = __DIR__ . '/data';
if (!is_dir($baseDir)) {
    @mkdir($baseDir, 0777, true);
}
$dsn = 'sqlite:' . $baseDir . '/database.sqlite';
$pdo = new PDO($dsn);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('CREATE TABLE IF NOT EXISTS tareas (id INTEGER PRIMARY KEY AUTOINCREMENT, titulo TEXT NOT NULL, completada INTEGER DEFAULT 0)');
?>