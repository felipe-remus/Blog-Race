<?php
session_start();

// Redireciona para login se não estiver autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Notícias</title>

    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/filtros.css">
    <link rel="stylesheet" href="css/minhas-noticias.css">
    <link rel="stylesheet" href="css/noticias.css">
    <link rel="stylesheet" href="css/paginacao.css">

    <script src="https://cdn.jsdelivr.net/npm/htmx.org@2.0.8/dist/htmx.min.js" integrity="sha384-/TgkGk7p307TH7EXJDuUlgG3Ce1UVolAOFopFekQkkXihi5u/6OCvVKyz1W+idaz" crossorigin="anonymous"></script>
</head>
<body>

    <!-- Header -->
    <div id="header">
        <?php require "../view/view_header.php"; ?>
    </div>

    <main>
        <div class="btn-base">
            <?php require '../view/view_btn-base.php' ?>
        </div>

        <h1 class="titulo-principal">Minhas Notícias</h1>

        <!-- Filtros: carrega categorias do banco -->
        <template
            hx-get="/proxy.php?p=model_filtros&contexto=minhas-noticias"
            hx-target="#filtro"
            hx-swap="innerHTML"
            hx-trigger="load">
        </template>
        <div id="filtro"></div>

        <!-- Notícias do usuário logado -->
        <template
            hx-get="/proxy.php?p=model_minhas-noticias"
            hx-target="#minhas-noticias-wrap"
            hx-swap="innerHTML"
            hx-trigger="load">
        </template>
        <div id="minhas-noticias-wrap"></div>
    </main>

    <!-- Footer -->
    <div id="footer">
        <?php require "../view/view_footer.php"; ?>
    </div>
</body>
</html>