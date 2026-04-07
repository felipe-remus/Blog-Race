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

$id_noticia = $_GET['id_noticia'];

try {
    $stmt = $pdo->prepare("DELETE FROM noticias WHERE id_noticia = ?");
    $stmt->execute([$id_noticia]);

    header('Location: ../index.php');
    exit;

} catch (PDOException $e) {
    header('Location: ../noticias.php');
    exit;
}