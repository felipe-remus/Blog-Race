<?php
if (empty($_SERVER['HTTP_HX_REQUEST'])) {
    header('Location: 404.php');
    exit;
}

require "../view/" . $_GET['p'] . ".php";
?>