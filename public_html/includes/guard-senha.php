<?php
if (isset($_SERVER['SCRIPT_FILENAME']) && $_SERVER['SCRIPT_FILENAME'] === __FILE__) {
    header('Location: ../404.php'); 
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// includes/guard_senha.php
// Inclua no TOPO de qualquer página que exige login.
// Se o usuário ainda tem a senha padrão, redireciona para login.php (perfil/troca de senha).

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Não está logado → vai para login
if (!isset($_SESSION['usuario'])) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Faça login para acessar esta página.'];
    header('Location: login.php');
    exit;
}

// Está logado mas ainda tem senha padrão → força a troca
if (!empty($_SESSION['must_change_password'])) {
    $_SESSION['flash'] = ['tipo' => 'aviso', 'mensagem' => 'Defina uma senha pessoal antes de continuar.'];
    header('Location: login.php');
    exit;
}