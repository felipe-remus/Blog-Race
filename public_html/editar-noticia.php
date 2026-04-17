<?php
session_start();

require_once "includes/guard-senha.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Blog Racing</title>

    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/noticias.css">
    <link rel="stylesheet" href="css/publicar.css">

    <script src="script/editar-noticia.js" defer></script>
</head>
<body>

    <div id="header">
        <?php require "../view/view_header.php"; ?>
    </div>

    <main>
        <div class="btn-base">
            <?php require '../view/view_btn-base.php'?>
        </div>

        <div id="eidtar-noticia">
            <?php require '../model/model_noticia-editar.php';?>
        </div>
    </main>

    <div id="footer">
        <?php require "../view/view_footer.php"; ?>
    </div>
</body>
</html>