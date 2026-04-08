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
    <script src="script/editar-noticia.js" defer></script>
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
        <div id="btn" style= "position: sticky; top: 0; z-index: 100;">
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