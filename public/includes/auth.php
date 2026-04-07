<?php
if (isset($_SERVER['SCRIPT_FILENAME']) && $_SERVER['SCRIPT_FILENAME'] === __FILE__) {
    header('Location: ../404.php'); 
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**Garante que o usuário está autenticado.*/
function requer_login(): void {
    if (empty($_SESSION['usuario'])) {
        // Armazena o motivo na sessão ANTES do redirecionamento
        $_SESSION['acesso_negado_motivo'] = 'login';
        $_SESSION['acesso_negado_destino'] = $_SERVER['REQUEST_URI'] ?? '/';

        header("Location: /acesso-restrito.php");
        exit; 
    }
}

/**Garante que o usuário está autenticado E possui perfil de administrador.*/
function requer_admin(): void {
    // Primeiro verifica se está logado
    if (empty($_SESSION['usuario'])) {
        // Se não estiver logado, o motivo é 'login'
        $_SESSION['acesso_negado_motivo'] = 'login';
        $_SESSION['acesso_negado_destino'] = $_SERVER['REQUEST_URI'] ?? '/';

        header("Location: /acesso-restrito.php"); // <-- Redireciona como se fosse um erro de login primeiro
        exit;
    }

    // Agora verifica se é admin
    if ((int) $_SESSION['usuario']['perfil_id'] !== 1) {
        // Está logado, mas não é admin. O motivo é 'permissao'
        $_SESSION['acesso_negado_motivo'] = 'permissao';
        $_SESSION['acesso_negado_destino'] = $_SERVER['REQUEST_URI'] ?? '/';

        header("Location: /acesso-restrito.php");
        exit;
    }
}