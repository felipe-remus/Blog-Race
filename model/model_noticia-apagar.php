<?php
// Inicia sessão para verificar permissões
session_start();

// Conectar ao banco
$pdo = new PDO("sqlite:../banco/blog_racing.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verificar se usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.html');
    exit;
}

$usuarioLogado = $_SESSION['usuario'];
$idUsuarioLogado = $usuarioLogado['id_usuario'];
$perfilUsuario = $usuarioLogado['perfil_id'];

// Verificar se ID da notícia foi fornecido
if (!isset($_GET['id_noticia']) || empty($_GET['id_noticia'])) {
    header('Location: ../noticias.html');
    exit;
}

$id_noticia = $_GET['id_noticia'];

try {
    // Buscar notícia para verificar o proprietário
    $stmt = $pdo->prepare("SELECT usuario_id FROM noticias WHERE id_noticia = ?");
    $stmt->execute([$id_noticia]);
    $noticia = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$noticia) {
        header('Location: ../noticias.html');
        exit;
    }
    
    $usuario_id_noticia = $noticia['usuario_id'];
    
    // Verificar permissões
    $pode_deletar = false;
    
    // Admin (perfil_id = 1) pode deletar qualquer notícia
    if ($perfilUsuario == 1) {
        $pode_deletar = true;
    }
    // User comum (perfil_id = 2) só pode deletar sua própria notícia
    else if ($perfilUsuario == 2 && $idUsuarioLogado == $usuario_id_noticia) {
        $pode_deletar = true;
    }
    
    if (!$pode_deletar) {
        // Usuário não tem permissão para deletar
        header('Location: ../noticias.html');
        exit;
    }
    
    // Deletar a notícia
    $stmt_delete = $pdo->prepare("DELETE FROM noticias WHERE id_noticia = ?");
    $stmt_delete->execute([$id_noticia]);
    
    // Redirecionar com sucesso
    header('Location: ../noticias.html?sucesso=deletado');
    exit;
    
} catch (PDOException $e) {
    header('Location: ../noticias.html');
    exit;
}
?>