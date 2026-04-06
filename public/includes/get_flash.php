<?php
// ============================================================
// 1. BLOQUEIO DE ACESSO DIRETO VIA URL
// ============================================================
if (isset($_SERVER['SCRIPT_FILENAME']) && $_SERVER['SCRIPT_FILENAME'] === __FILE__) {
    header('Location: /404.php');
    exit;
}

// ============================================================
// 2. VALIDAÇÃO DE CHAMADA INTERNA (JS/Fetch)
// ============================================================
// Exige um header customizado. Se alguém tentar acessar via GET sem ser o seu JS, bloqueia.
$isInternalFetch = ($_SERVER['HTTP_X_INTERNAL_CALL'] ?? '') === 'true';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !$isInternalFetch) {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso não autorizado.']);
    exit;
}

// public/actions/get_flash.php
// Endpoint dedicado: lê e limpa o flash da sessão, retorna JSON.
// Chamado pelo JS após fetch de formulários (publicar, login, etc.)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

echo json_encode($flash);