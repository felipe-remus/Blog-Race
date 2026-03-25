<?php
// Inicia sessão para verificar se usuário está logado
session_start();
$usuarioLogado = isset($_SESSION['usuario']);
$nomeUsuario = $usuarioLogado ? $_SESSION['usuario']['nome'] : '';
$perfilUsuario = $usuarioLogado ? $_SESSION['usuario']['perfil_id'] : null;
?>

<header id="cabecalho">
    <div id="logo-cabecalho">
        <img src="../img/Marca-F1.svg" alt="Logo F1">
    </div>
    <nav id="menu-principal">
        <a href="../index.html" class="nav-link" data-page="index.html">Home</a>
        <a href="../noticias.html" class="nav-link" data-page="noticias.html">Notícias</a>
        <a href="../historia.html" class="nav-link" data-page="historia.html">História</a>
        
        <?php if ($usuarioLogado): ?>
            <!-- Link Admin - Aparece apenas para perfil_id = 1 -->
            <?php if ($perfilUsuario == 1): ?>
                <a href="../model/model_admin.php" class="nav-link admin-link">Painel Admin</a>
            <?php endif; ?>
            
            <span class="nav-link">Olá, <?php echo htmlspecialchars($nomeUsuario); ?></span>
            <a href="../model/model_logout.php" class="nav-link logout-btn">Sair</a>
        <?php else: ?>
            <a href="../login.html" class="nav-link" data-page="login.html">Login</a>
        <?php endif; ?>
    </nav>
</header>