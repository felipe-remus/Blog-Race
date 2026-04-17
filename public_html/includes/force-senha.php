<?php
// includes/force_senha.php
// Inclua este arquivo em TODA página protegida (após session_start e requer_login/admin).
// Se o usuário logado ainda tiver senha temporária, redireciona para o perfil
// e impede qualquer outra ação até que ele troque a senha.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario']['senha_temporaria'])) {
    $_SESSION['flash'] = [
        'tipo'     => 'aviso',
        'mensagem' => 'Você precisa definir uma nova senha antes de continuar.',
    ];
    header('Location: login.php');
    exit;
}