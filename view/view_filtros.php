<div class="filtros-wrapper">
    <div class="busca-container">
        <input type="text" id="busca-texto" placeholder="Pesquisar Noticias...">
    </div>

    <!-- Filtro por categoria -->
    <div class="filtro-container">
        <select id="filtro-categoria" name="categoria" class="filtro-select">
        <option value="">Selecione a Categoria</option>
        <?php foreach ($categorias as $chave => $valor): ?>
            <option value="<?= $chave ?>"><?= $valor ?></option>
        <?php endforeach; ?>
    </select>
    </div>

    <!-- Filtro por data -->
    <div class="filtro-data-container">
        <label>Filtrar por Data</label>
        <div class="filtro-data-inputs">
            <div class="filtro-data-grupo">
                <span>De</span>
                <input type="date" id="filtro-data-inicio" name="data_inicio" class="filtro-data" value="<?= $data_inicio ?>"></div>
            <div class="filtro-data-grupo">
                <span>Até</span>
                <input type="date" id="filtro-data-fim" name="data_fim" class="filtro-data" value="<?= $data_fim ?>"></div>
        </div>
    </div>
</div>