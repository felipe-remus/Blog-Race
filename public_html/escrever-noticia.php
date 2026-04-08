<?php
require_once "includes/auth.php";
requer_login();

// Dispatcher — intercepta POST antes de renderizar a página
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../model/model_noticia-publicar.php';
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escrever Notícia</title>

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

    <script src="script/header.js" defer></script>
    <script src="script/historia.js" defer></script>
    <script src="script/login.js" defer></script>
    <script src="script/modal-noticia.js" defer></script>
    <script src="script/publicar.js" defer></script>
    <script src="script/slider.js" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/htmx.org@2.0.8/dist/htmx.min.js"
            integrity="sha384-/TgkGk7p307TH7EXJDuUlgG3Ce1UVolAOFopFekQkkXihi5u/6OCvVKyz1W+idaz"
            crossorigin="anonymous"></script>
</head>
<body>

    <div id="header">
        <?php require "../view/view_header.php"; ?>
    </div>

    <main>
        <div id="btn" style= "position: sticky; top: 0; z-index: 100;">
            <?php require '../view/view_btn-base.php'?>
        </div>

        <template
            hx-get="/proxy.php?p=model_noticia-publicar"
            hx-target="#publicar"
            hx-swap="innerHTML"
            hx-trigger="load">
        </template>
        <div id="publicar"></div>
    </main>

    <div id="footer">
        <?php require "../view/view_footer.php"; ?>
    </div>

</body>
</html>