<?php
if (empty($_SERVER['HTTP_HX_REQUEST'])) {
    header('Location: 404.php');
    exit;
}

require "../model/" . $_GET['p'] . ".php";
?>