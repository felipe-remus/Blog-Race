<?php
require "model_conexao.php";

$rs = $pdo->query("SELECT sigla_categoria, nome_categoria FROM categorias");

$categorias = [];
while ($linha = $rs->fetch(PDO::FETCH_ASSOC)) {
    $categorias[$linha['sigla_categoria']] = $linha['nome_categoria'];
}