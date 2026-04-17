<?php
// model/model_editar-usuario.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Usuário deve estar logado
if (!isset($_SESSION['usuario'])) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Faça login para acessar esta página'];
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Conexão
$pdo = new PDO("sqlite:" . __DIR__ . "/../banco/blog_racing.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_usuario           = $_SESSION['usuario']['id_usuario'];
$nome                 = trim($_POST['nome']                 ?? '');
$user                 = trim($_POST['user']                 ?? '');
$email                = trim($_POST['email']                ?? '');
$telefone             = trim($_POST['telefone']             ?? '');
$senha_atual          =      $_POST['senha_atual']          ?? '';
$senha_nova           =      $_POST['senha_nova']           ?? '';
$confirmar_senha_nova =      $_POST['confirmar_senha_nova'] ?? '';

$tem_senha_temporaria = !empty($_SESSION['must_change_password']);

// Validações básicas
if (empty($nome)) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Nome é obrigatório'];
    header('Location: login.php');
    exit;
}

if (empty($user)) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Nome de usuário é obrigatório'];
    header('Location: login.php');
    exit;
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Email inválido'];
    header('Location: login.php');
    exit;
}

// Se o usuário tem senha temporária, a troca de senha é OBRIGATÓRIA
if ($tem_senha_temporaria) {
    if (empty($senha_atual) || empty($senha_nova) || empty($confirmar_senha_nova)) {
        $_SESSION['flash'] = ['tipo' => 'aviso', 'mensagem' => 'Você deve definir uma nova senha antes de continuar.'];
        header('Location: login.php');
        exit;
    }
}

// Verificar alteração de senha
$alterar_senha = !empty($senha_nova);
$senha_hash    = null;

if ($alterar_senha) {
    if (empty($senha_atual)) {
        $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Digite sua senha atual para alterar a senha'];
        header('Location: login.php');
        exit;
    }

    // Verifica senha atual no banco
    $stmt_user = $pdo->prepare("SELECT senha FROM usuarios WHERE id_usuario = :id_usuario");
    $stmt_user->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt_user->execute();
    $usuario_atual = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if (!$usuario_atual || !password_verify($senha_atual, $usuario_atual['senha'])) {
        $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Senha atual incorreta'];
        header('Location: login.php');
        exit;
    }

    if (strlen($senha_nova) < 6) {
        $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Nova senha deve ter no mínimo 6 caracteres'];
        header('Location: login.php');
        exit;
    }

    if ($senha_nova !== $confirmar_senha_nova) {
        $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'As senhas não coincidem'];
        header('Location: login.php');
        exit;
    }

    $senha_hash = password_hash($senha_nova, PASSWORD_DEFAULT);
}

// Se deve trocar a senha, impede salvar sem trocar
if ($tem_senha_temporaria && !$alterar_senha) {
    $_SESSION['flash'] = ['tipo' => 'aviso', 'mensagem' => 'Defina uma nova senha antes de continuar.'];
    header('Location: login.php');
    exit;
}

try {
    // Verifica duplicidade (excluindo o próprio usuário)
    $stmt_check = $pdo->prepare(
        "SELECT id_usuario FROM usuarios
            WHERE (user = :user OR email = :email) AND id_usuario != :id_usuario"
    );
    $stmt_check->bindValue(':user', $user);
    $stmt_check->bindValue(':email', $email);
    $stmt_check->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt_check->execute();

    if ($stmt_check->fetch()) {
        $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Usuário ou email já cadastrado por outro usuário'];
        header('Location: login.php');
        exit;
    }

    // Atualiza no banco
    if ($alterar_senha) {
        // Senha trocada 
        $stmt = $pdo->prepare(
            "UPDATE usuarios
                SET nome = :nome, user = :user, email = :email, telefone = :telefone, senha = :senha
                WHERE id_usuario = :id_usuario"
        );
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':user', $user);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':telefone', $telefone);
        $stmt->bindValue(':senha', $senha_hash);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $pdo->prepare(
            "UPDATE usuarios SET nome = :nome, user = :user, email = :email, telefone = :telefone
                WHERE id_usuario = :id_usuario"
        );
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':user', $user);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':telefone', $telefone);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
    }

    if ($alterar_senha) {
        // Destrói sessão e redireciona para login
        session_destroy();
        session_start();
        $_SESSION['flash'] = [
            'tipo'     => 'sucesso',
            'mensagem' => 'Senha alterada! Faça login com sua nova senha.',
        ];
        header('Location: login.php');
        exit;
    } else {
        // Atualiza sessão com novos dados (sem alterar senha)
        $_SESSION['usuario']['nome']     = $nome;
        $_SESSION['usuario']['user']     = $user;
        $_SESSION['usuario']['email']    = $email;
        $_SESSION['usuario']['telefone'] = $telefone;

        $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'Perfil atualizado com sucesso!'];
        header('Location: index.php');
        exit;
    }

} catch (PDOException $e) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => $e->getMessage()];
    header('Location: login.php');
    exit;
}