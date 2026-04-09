<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/noticias.css">
    <link rel="stylesheet" href="css/slider.css">

    <script src="https://cdn.jsdelivr.net/npm/htmx.org@2.0.8/dist/htmx.min.js" integrity="sha384-/TgkGk7p307TH7EXJDuUlgG3Ce1UVolAOFopFekQkkXihi5u/6OCvVKyz1W+idaz" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Header: include direto, sem requisição HTTP extra -->
    <div id="header">
        <?php require "../view/view_header.php"; ?>
    </div>

    <!-- Slider Hero: include direto, sem requisição HTTP extra -->
    <div id="slider">
        <?php require "../view/view_slider.php"; ?>
    </div>

    <main>
        <!-- Notícias: HTMX mantido pois responde a filtros e paginação dinâmica -->
        <template
            hx-get="/proxy.php?p=model_noticia&modo=home"
            hx-target="#noticia"
            hx-swap="innerHTML"
            hx-trigger="load">
        </template>
        <div id="noticia"></div>

        <div class="ver-todas-container">
            <a href="noticias.php" class="btn-ver-todas">Ver todas as notícias →</a>
        </div>
    </main>

    <!-- Footer: include direto, sem requisição HTTP extra -->
    <div id="footer">
        <?php require "../view/view_footer.php"; ?>
    </div>
</body>
</html>