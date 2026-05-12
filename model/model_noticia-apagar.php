<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header('Location: ../404.php');
    exit;
}

if (!isset($_GET['id_noticia']) || empty($_GET['id_noticia'])) {
    header('Location: ../404.php');
    exit;
}

require "model_conexao.php";

$id_noticia    = $_GET['id_noticia'];
$perfilUsuario = (int) $_SESSION['usuario']['perfil_id'];

// Pega a página de origem passada pela URL; se não vier, usa fallback pelo perfil
$origens_permitidas = ['noticias.php', 'minhas-noticias.php'];
$origem  = $_GET['origem'] ?? null;
$destino = in_array($origem, $origens_permitidas)
    ? '../' . $origem
    : ($perfilUsuario === 1 ? '../noticias.php' : '../minhas-noticias.php');

try {
    $stmt = $pdo->prepare("DELETE FROM noticias WHERE id_noticia = :id_noticia");
    $stmt->bindValue(':id_noticia', $id_noticia, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: ' . $destino);
    exit;

} catch (PDOException $e) {
    header('Location: ' . $destino);
    exit;
}