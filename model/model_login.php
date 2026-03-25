<?php
// Inicia sessão
session_start();

// Conectar ao banco
$pdo = new PDO("sqlite:../banco/blog_racing.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verificar se é requisição AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $email_user = trim($_POST['email_login'] ?? '');
    $senha = $_POST['senha_login'] ?? '';
    
    // Validações
    if (empty($email_user)) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Email ou usuário é obrigatório']);
        exit;
    }
    
    if (empty($senha)) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Senha é obrigatória']);
        exit;
    }
    
    try {
        // Buscar usuário por email ou username
        $sql = "SELECT id_usuario, nome, user, email, telefone, senha, perfil_id 
                FROM usuarios 
                WHERE email = ? OR user = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email_user, $email_user]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuario) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário ou email não encontrado']);
            exit;
        }
        
        // Verificar senha
        if (!password_verify($senha, $usuario['senha'])) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Senha incorreta']);
            exit;
        }
        
        // Criar sessão
        $_SESSION['usuario'] = [
            'id_usuario' => $usuario['id_usuario'],
            'nome' => $usuario['nome'],
            'user' => $usuario['user'],
            'email' => $usuario['email'],
            'telefone' => $usuario['telefone'],
            'perfil_id' => $usuario['perfil_id']
        ];
        
        echo json_encode([
            'sucesso' => true, 
            'mensagem' => 'Login realizado com sucesso!',
            'usuario' => $_SESSION['usuario']
        ]);
        
    } catch (PDOException $e) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao processar login']);
    }
    exit;
}
?>