<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    if ($usuario === '') {
        http_response_code(422);
        echo 'Usuario requerido';
        exit;
    }
    $_SESSION['usuario'] = $usuario;
    echo $_SESSION['usuario'];
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    session_destroy();
    echo 'cerrada';
    exit;
}

echo isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
?>