<?php
// model/model_admin.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexão
$pdo = new PDO("sqlite:" . __DIR__ . "/../banco/blog_racing.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ============================================================
// PROCESSAR REQUISIÇÕES POST
// ============================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // ---------- DELETAR USUÁRIO ----------
    if ($acao === 'deletar_usuario') {
        $id = intval($_POST['id_usuario'] ?? 0);

        if ($id <= 0) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'ID de usuário inválido'];
            header('Location: admin.php');
            exit;
        }

        // Impede que o admin delete a própria conta
        if ($id === (int) $_SESSION['usuario']['id_usuario']) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Você não pode deletar sua própria conta'];
            header('Location: admin.php');
            exit;
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
            $stmt->execute([$id]);
            $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'Usuário deletado com sucesso'];
        } catch (PDOException $e) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Erro ao deletar usuário'];
        }

        header('Location: admin.php');
        exit;
    }

    // ---------- ATUALIZAR PERFIL ----------
    if ($acao === 'atualizar_perfil') {
        $id        = intval($_POST['id_usuario'] ?? 0);
        $perfil_id = intval($_POST['perfil_id']  ?? 0);

        if ($id <= 0 || $perfil_id <= 0) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Dados inválidos'];
            header('Location: admin.php');
            exit;
        }

        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET perfil_id = ? WHERE id_usuario = ?");
            $stmt->execute([$perfil_id, $id]);
            $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'Perfil atualizado com sucesso'];
        } catch (PDOException $e) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Erro ao atualizar perfil'];
        }

        header('Location: admin.php');
        exit;
    }

    // ---------- REDEFINIR SENHA ----------
    if ($acao === 'redefinir_senha') {
        $id = intval($_POST['id_usuario'] ?? 0);

        if ($id <= 0) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'ID de usuário inválido'];
            header('Location: admin.php');
            exit;
        }

        // Admin não pode redefinir a própria senha por aqui (usa o perfil)
        if ($id === (int) $_SESSION['usuario']['id_usuario']) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Use a página de perfil para alterar sua própria senha'];
            header('Location: admin.php');
            exit;
        }

        try {
            $senha_padrao = 'RacingBlog123';
            $senha_hash   = password_hash($senha_padrao, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "UPDATE usuarios SET senha = ? WHERE id_usuario = ?"
            );
            $stmt->execute([$senha_hash, $id]);

            $_SESSION['flash'] = [
                'tipo'     => 'sucesso',
                'mensagem' => "Senha redefinida para a padrão. O usuário deverá alterá-la no próximo acesso.",
            ];
        } catch (PDOException $e) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Erro ao redefinir senha'];
        }

        header('Location: admin.php');
        exit;
    }

    // Ação desconhecida
    header('Location: admin.php');
    exit;
}

// ============================================================
// CARREGAR DADOS PARA EXIBIÇÃO (GET)
// ============================================================

// Categorias
$categorias = $pdo->query("SELECT * FROM categorias ORDER BY id_categoria")->fetchAll(PDO::FETCH_ASSOC);

// Usuários com perfil
$usuarios = $pdo->query("
    SELECT
        u.id_usuario,
        u.nome,
        u.user,
        u.email,
        u.telefone,
        p.id_perfil,
        p.nome_perfil
    FROM usuarios u
    JOIN perfis p ON u.perfil_id = p.id_perfil
    ORDER BY u.nome")->fetchAll(PDO::FETCH_ASSOC);

// Perfis disponíveis (para o <select>)
$perfis = $pdo->query("SELECT * FROM perfis ORDER BY nome_perfil")->fetchAll(PDO::FETCH_ASSOC);

// Estatísticas
$stats = $pdo->query("
    SELECT
        (SELECT COUNT(*) FROM usuarios)                                          AS total_usuarios,
        (SELECT COUNT(*) FROM categorias)                                        AS total_categorias,
        (SELECT COUNT(*) FROM noticias)                                          AS total_noticias,
        (SELECT COUNT(*) FROM noticias WHERE DATE(data_noticia) = DATE('now'))   AS noticias_hoje")->fetch(PDO::FETCH_ASSOC);

// Lê e limpa o flash de sessão
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

require __DIR__ . "/../view/view_admin.php";