<?php
// __DIR__ garante o caminho absoluto ao arquivo, independente de onde ele é incluído
$pdo = new PDO("sqlite:" . __DIR__ . "/../banco/blog_racing.db");

$rs = $pdo->query("SELECT sigla_categoria, nome_categoria FROM categorias");

$categorias = [];
while ($linha = $rs->fetch(PDO::FETCH_ASSOC)) {
    $categorias[$linha['sigla_categoria']] = $linha['nome_categoria'];
}