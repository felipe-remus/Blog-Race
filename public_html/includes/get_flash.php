<?php
// get_flash.php
if (
    !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'
) {
    header('Location: ../404.php'); 
    exit;
}
// public_html/actions/get_flash.php
// Endpoint dedicado: lê e limpa o flash da sessão, retorna JSON.
// Chamado pelo JS após fetch de formulários (publicar, login, etc.)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

echo json_encode($flash);