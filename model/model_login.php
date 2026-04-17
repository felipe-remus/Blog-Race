<?php
// model/model_login.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexão
$pdo = new PDO("sqlite:" . __DIR__ . "/../banco/blog_racing.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email_user = trim($_POST['email_login'] ?? '');
$senha      = $_POST['senha_login']      ?? '';

// Validações
if (empty($email_user)) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Email ou usuário é obrigatório'];
    header('Location: login.php');
    exit;
}

if (empty($senha)) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Senha é obrigatória'];
    header('Location: login.php');
    exit;
}

try {
    $stmt = $pdo->prepare(
        "SELECT id_usuario, nome, user, email, telefone, senha, perfil_id
            FROM usuarios
            WHERE email = :email_user OR user = :user"
    );
    $stmt->bindValue(':email_user', $email_user);
    $stmt->bindValue(':user', $email_user);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario || !password_verify($senha, $usuario['senha'])) {
        $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Usuário ou senha incorretos'];
        header('Location: login.php');
        exit;
    }

    // Cria a sessão do usuário
    $_SESSION['usuario'] = [
        'id_usuario' => $usuario['id_usuario'],
        'nome'       => $usuario['nome'],
        'user'       => $usuario['user'],
        'email'      => $usuario['email'],
        'telefone'   => $usuario['telefone'],
        'perfil_id'  => $usuario['perfil_id'],
    ];

    // Se a senha ainda é a padrão do sistema, força a troca antes de qualquer coisa
    if (password_verify('RacingBlog123', $usuario['senha'])) {
        $_SESSION['must_change_password'] = true;
        $_SESSION['flash'] = [
            'tipo'     => 'aviso',
            'mensagem' => 'Bem-vindo! Por segurança, defina uma nova senha para continuar.',
        ];
        header('Location: perfil.php');
        exit;
    }

    $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'Login realizado com sucesso!'];
    header('Location: index.php');
    exit;

} catch (PDOException $e) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Erro ao processar login. Tente novamente.'];
    header('Location: login.php');
    exit;
}