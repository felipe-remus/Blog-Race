<?php
require_once "includes/auth.php";
requer_admin();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Blog Racing</title>

    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/filtros.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/historia.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/noticias.css">
    <link rel="stylesheet" href="css/paginacao.css">
    <link rel="stylesheet" href="css/publicar.css">
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/tags.css">

    <script src="script/admin.js" defer></script>
    <script src="script/header.js" defer></script>
    <script src="script/historia.js" defer></script>
    <script src="script/modal-noticia.js" defer></script>
    <script src="script/slider.js" defer></script>
</head>
<body>

    <div id="header">
        <?php require "../view/view_header.php"; ?>
    </div>

    <main>
        <!-- Botão "Voltar para a Home" -->
        <div class="voltar-home">
            <a href="index.php" class="btn-voltar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Voltar para a Home</span>
            </a>
        </div>

        <div id="admin">
            <?php require '../model/model_admin.php'?>
        </div>
    </main>

    <div id="footer">
        <?php require "../view/view_footer.php"; ?>
    </div>
</body>
</html>