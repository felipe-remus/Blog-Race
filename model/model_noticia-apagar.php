<?php
session_start();

// Conectar ao banco
$pdo = new PDO("sqlite:../banco/blog_racing.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verificar se usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

// Verificar se ID da notícia foi fornecido
if (!isset($_GET['id_noticia']) || empty($_GET['id_noticia'])) {
    header('Location: ../noticias.php');
    exit;
}

$id_noticia = $_GET['id_noticia'];

try {
    $stmt = $pdo->prepare("DELETE FROM noticias WHERE id_noticia = ?");
    $stmt->execute([$id_noticia]);

    header('Location: ../noticias.php');
    exit;

} catch (PDOException $e) {
    header('Location: ../noticias.php');
    exit;
}
?>