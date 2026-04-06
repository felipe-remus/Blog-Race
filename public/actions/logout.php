<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o token foi enviado e corresponde ao da sessão
$token_enviado   = $_GET['token'] ?? '';
$token_esperado  = $_SESSION['logout_token'] ?? '';

if (empty($token_enviado) || !hash_equals($token_esperado, $token_enviado)) {
    header('Location: ../404.php');
    exit;
}

// Token válido: remove para evitar reuso, destrói a sessão e redireciona
unset($_SESSION['logout_token']);
session_destroy();
header('Location: ../index.php');
exit;
?>