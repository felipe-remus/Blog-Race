<?php
//Conectar
$pdo = new PDO("sqlite:banco/blog_racing.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verificar se é requisição AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $nome = trim($_POST['nome_registro'] ?? '');
    $user = trim($_POST['user_registro'] ?? '');
    $email = trim($_POST['email_registro'] ?? '');
    $telefone = trim($_POST['fone_registro'] ?? '');
    $senha = $_POST['senha_registro'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha_registro'] ?? '';
    
    // Validações
    if (empty($nome)) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Nome é obrigatório']);
        exit;
    }
    
    if (empty($user)) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Nome de usuário é obrigatório']);
        exit;
    }
    
    if (empty($email)) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Email é obrigatório']);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Email inválido']);
        exit;
    }
    
    if (empty($senha)) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Senha é obrigatória']);
        exit;
    }
    
    if (strlen($senha) < 6) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Senha deve ter no mínimo 6 caracteres']);
        exit;
    }
    
    if ($senha !== $confirmar_senha) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'As senhas não coincidem']);
        exit;
    }
    
    // Verificar se usuário ou email já existem
    $stmt_check = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE user = ? OR email = ?");
    $stmt_check->execute([$user, $email]);
    if ($stmt_check->fetch()) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário ou email já cadastrado']);
        exit;
    }
    
    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    
    try {
        $sql_registro = "
        INSERT INTO usuarios (nome, user, email, telefone, senha, perfil_id)
        VALUES (:nome_registro, :user_registro, :email_registro, :fone_registro, :senha_registro, 2);";
        
        $stmt = $pdo->prepare($sql_registro);
        $stmt->bindValue(':nome_registro', $nome);
        $stmt->bindValue(':user_registro', $user);
        $stmt->bindValue(':email_registro', $email);
        $stmt->bindValue(':fone_registro', $telefone);
        $stmt->bindValue(':senha_registro', $senha_hash);
        $stmt->execute();
        
        echo json_encode(['sucesso' => true, 'mensagem' => 'Conta criada com sucesso!']);
    } catch (PDOException $e) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao criar conta. Tente novamente.']);
    }
    exit;
}
?>