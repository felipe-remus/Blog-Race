<?php
$contexto         = $_GET['contexto'] ?? 'noticias';
$filtros_endpoint = $contexto === 'minhas-noticias' ? 'model_minhas-noticias' : 'model_noticia';
$filtros_target   = $contexto === 'minhas-noticias' ? '#minhas-noticias-wrap'  : '#noticia';

require "model_categoria.php";
require "../view/view_filtros.php";
?>