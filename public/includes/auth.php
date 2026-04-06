<?php
// 🔒 IMPEDIÇÃO DE ACESSO DIRETO VIA URL
// Se o arquivo atual for exatamente o mesmo que o servidor está executando,
// significa que alguém digitou o caminho no navegador → bloqueia e redireciona.
if (isset($_SERVER['SCRIPT_FILENAME']) && $_SERVER['SCRIPT_FILENAME'] === __FILE__) {
    header('Location: ../404.php'); 
    exit;
}

/**
* includes/auth.php
* Funções de guarda de autenticação e autorização.
* Inclua este arquivo APÓS session_start() em qualquer página protegida.
*
* Uso:
*   requer_login();                    → redireciona se não estiver logado
*   requer_admin();                    → redireciona se não for admin (perfil_id = 1)
*/

// Garantir que a sessão esteja iniciada assim que este arquivo for incluído
// Só inicia se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
* Garante que o usuário está autenticado.
* Redireciona para a página de acesso restrito se não estiver logado.
*/
function requer_login(): void {
    if (empty($_SESSION['usuario'])) {
        // Armazena o motivo na sessão ANTES do redirecionamento
        $_SESSION['acesso_negado_motivo'] = 'login';
        $_SESSION['acesso_negado_destino'] = $_SERVER['REQUEST_URI'] ?? '/'; // Armazena destino também, se necessário

        header("Location: /acesso-restrito.php"); // <-- Agora SEM motivo na URL
        exit; // Muito importante para evitar que o resto da página carregue
    }
}

/**
* Garante que o usuário está autenticado E possui perfil de administrador.
* perfil_id = 1  →  administrador
* Redireciona para a página de acesso restrito caso contrário.
*/
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

        header("Location: /acesso-restrito.php"); // <-- Agora SEM motivo na URL
        exit;
    }
}