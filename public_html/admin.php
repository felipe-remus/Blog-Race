<?php
session_start();

require_once "includes/auth.php";
requer_admin();

require_once "includes/guard-senha.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>

    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/login.css">

    <script src="script/admin.js" defer></script>
    <script src="script/login.js" defer></script>
</head>
<body>

    <div id="header">
        <?php require "../view/view_header.php"; ?>
    </div>

    <main>
        <div class="btn-base">
            <?php require '../view/view_btn-base.php'?>
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