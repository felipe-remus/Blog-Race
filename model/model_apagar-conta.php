<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header('Location: ../404.php');
    exit;
}

if (!isset($_GET['id_usuario']) || empty($_GET['id_usuario'])) {
    header('Location: ../404.php');
    exit;
}

// Conexão
$pdo = new PDO("sqlite:" . __DIR__ . "/../banco/blog_racing.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_usuario = $_GET['id_usuario'];

try {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = :id_usuario");
    $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    session_destroy();
    header('Location: ../index.php');
    exit;

} catch (PDOException $e) {
    header('Location: ../login.php');
    exit;
}