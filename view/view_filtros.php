<div class="filtros-wrapper">
    <div class="busca-container">
        <input type="text" id="busca-texto" placeholder="Pesquisar Noticias...">
    </div>

    <!-- Filtro por categoria -->
    <div class="filtro-container">
        <select id="filtro-categoria" name="categoria" class="filtro-select">
        <option value="">Selecione a Categoria</option>
        
        <option value="f1" ><?= $categorias["f1"]?></option>
        <option value="f2" ><?= $categorias["f2"]?></option>
        <option value="f3" ><?= $categorias["f3"]?></option>
        <option value="f4" ><?= $categorias["f4"]?></option>
        <option value="f1academy" ><?= $categorias["f1academy"]?></option>
        <option value="fe" ><?= $categorias["fe"]?></option>
        <option value="indy" ><?= $categorias["indy"]?></option>
        <option value="wec" ><?= $categorias["wec"]?></option>
        <option value="wrc" ><?= $categorias["wrc"]?></option>
        <option value="nascar" ><?= $categorias["nascar"]?></option>
        <option value="moto" ><?= $categorias["moto"]?></option>
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