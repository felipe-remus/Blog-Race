<?php
// Sessão já iniciada na página pai (index.php, noticias.php etc.)
// A proteção abaixo garante funcionamento em qualquer contexto:
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuarioLogado = isset($_SESSION['usuario']);
$nomeUsuario   = $usuarioLogado ? $_SESSION['usuario']['nome'] : '';
$perfilUsuario = $usuarioLogado ? $_SESSION['usuario']['perfil_id'] : null;

// Gera um token único e seguro para esta sessão
$logout_token = bin2hex(random_bytes(16));
$_SESSION['logout_token'] = $logout_token;
?>

<header id="cabecalho">
    <div id="logo-cabecalho">
        <img src="../img/Marca-F1.svg" alt="Logo F1">
    </div>
    <nav id="menu-principal">
        <a href="index.php"    class="nav-link" data-page="index.php">Home</a>
        <a href="noticias.php" class="nav-link" data-page="noticias.php">Notícias</a>
        <a href="historia.php" class="nav-link" data-page="historia.php">História</a>

        <?php if ($usuarioLogado): ?>
            <?php if ($perfilUsuario == 1): ?>
                <a href="admin.php" class="nav-link admin-link">Painel Admin</a>
            <?php endif; ?>
            <span class="nav-link">Olá, <?php echo htmlspecialchars($nomeUsuario); ?></span>
            <a href="actions/logout.php?token=<?= $logout_token ?>" class="nav-link logout-btn">Sair</a>
        <?php else: ?>
            <a href="login.php" class="nav-link" data-page="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>