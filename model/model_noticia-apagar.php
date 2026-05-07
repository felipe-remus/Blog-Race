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

// Conexão
$pdo = new PDO("sqlite:" . __DIR__ . "/../banco/blog_racing.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_noticia    = $_GET['id_noticia'];
$perfilUsuario = (int) $_SESSION['usuario']['perfil_id'];
$destino       = $perfilUsuario === 1 ? '../noticias.php' : '../minhas-noticias.php';

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