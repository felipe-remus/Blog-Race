<link rel="stylesheet" href="../css/admin.css">
<link rel="stylesheet" href="../css/base.css">
<link rel="stylesheet" href="../css/filtros.css">
<link rel="stylesheet" href="../css/footer.css">
<link rel="stylesheet" href="../css/header.css">
<link rel="stylesheet" href="../css/historia.css">
<link rel="stylesheet" href="../css/login.css">
<link rel="stylesheet" href="../css/noticias.css">
<link rel="stylesheet" href="../css/paginacao.css">
<link rel="stylesheet" href="../css/publicar.css">
<link rel="stylesheet" href="../css/slider.css">
<link rel="stylesheet" href="../css/tags.css">

<script src="../script/editar-noticia.js" defer></script>
<script src="../script/header.js" defer></script>
<script src="../script/historia.js" defer></script>
<script src="../script/modal-noticia.js" defer></script>
<script src="../script/slider.js" defer></script>

<div class="publicar-container">
    <div class="publicar-wrapper">
        <!-- PAINEL DE CONTROLES -->
        <div class="publicar-controls">
            <h1>Editar sua Notícia</h1>

            <!-- enctype obrigatório para enviar arquivo -->
            <form id="form-noticia" method="POST" enctype="multipart/form-data">

                <!-- Campo oculto com a imagem atual (usada se nenhuma nova for enviada) -->
                <input type="hidden" name="img_atual" value="<?= $imagem_noticia_editar ?>">

                <!-- Título -->
                <div class="form-campo">
                    <label for="input-titulo">Título da Notícia *</label>
                    <input 
                        type="text" 
                        id="input-titulo"
                        name="titulo"
                        value="<?= $titulo_noticia_editar ?>"
                        required>
                </div>

                <!-- Imagem -->
                <div class="form-campo">
                    <label for="input-imagem">Imagem da Notícia</label>
                    <div class="input-file-wrapper">
                        <button type="button" class="btn-remover-imagem" id="btnRemoverImagem" title="Remover imagem selecionada">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </button>
                        <!-- name="img" para o $_FILES['img'] no model -->
                        <input 
                            type="file" 
                            id="input-imagem"
                            name="img"
                            accept="image/*">
                        <span class="file-label">Escolher imagem</span>
                        <span class="file-name" id="file-name"><?= $imagem_noticia_editar ?></span>
                    </div>
                </div>

                <!-- Texto/Conteúdo -->
                <div class="form-campo">
                    <label for="input-conteudo">Conteúdo da Notícia *</label>
                    <textarea 
                        id="input-conteudo"
                        rows="15"
                        name="texto" 
                        required><?= $texto_noticia_editar ?></textarea>
                </div>

                <!-- Categoria -->
                <div class="form-campo">
                    <label>Categoria *</label>
                    <div class="categoria-tabs">
                        <?php foreach ($categorias as $chave => $valor): 
                            $classeAtiva = ($chave === $sigla_categoria_editar) ? 'ativo' : '';
                        ?>
                            <button type="button" class="categoria-btn <?= $classeAtiva ?>" data-categoria="<?= $chave ?>">
                                <?= $valor ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" id="categoria-selecionada" name="categoria">
                </div>

                <button type="submit" class="btn-publicar">Republicar Notícia</button>
            </form>
        </div>

        <!-- PREVIEW DO CARD -->
        <div class="publicar-preview">
            <h2>Pré-visualização</h2>
            <div class="noticias-container preview-container">
                <article class="card-noticia card-preview">
                    <div class="card-imagem" id="preview-imagem-container">
                        <img 
                            id="preview-imagem" 
                            src="<?= $imagem_noticia_editar ?>"
                            alt="Preview da imagem"
                            loading="lazy">
                        <span class="card-imagem-badge" id="preview-categoria-badge"><?= $categoria_noticia_editar ?></span>
                    </div>

                    <div class="card-body">
                        <div class="card-header">
                            <h2 id="preview-titulo" class="preview-text"><?= $titulo_noticia_editar ?></h2>
                            <p class="meta">
                                <svg class="meta-icon" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <span id="preview-data"></span>
                                <span class="separador">•</span>
                                <svg class="meta-icon" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <span id="preview-autor"><?= $user_noticia_editar ?></span>
                            </p>
                        </div>
                        <p class="card-conteudo" id="preview-conteudo"><?= $texto_noticia_editar ?></p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>