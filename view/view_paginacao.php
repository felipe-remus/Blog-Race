<div class="paginacao-container"
    id="paginacao"
    data-pagina-atual="<?= $pagina_atual ?>"
    data-total-paginas="<?= $total_paginas ?>"
    data-endpoint="<?= htmlspecialchars($paginacao_endpoint ?? 'model_noticia') ?>"
    data-target="<?= htmlspecialchars($paginacao_target   ?? '#noticia') ?>">

    <button class="paginacao-btn" id="btn-primeira" title="Primeira página"
            <?= $pagina_atual === 1 ? 'disabled' : '' ?>>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="11 17 6 12 11 7"></polyline>
            <polyline points="18 17 13 12 18 7"></polyline>
        </svg>
    </button>

    <button class="paginacao-btn" id="btn-anterior" title="Página anterior"
            <?= $pagina_atual === 1 ? 'disabled' : '' ?>>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
    </button>

    <span class="paginacao-info-pagina">
        <?= $pagina_atual ?> / <?= $total_paginas ?>
    </span>

    <button class="paginacao-btn" id="btn-proxima" title="Próxima página"
            <?= $pagina_atual === $total_paginas ? 'disabled' : '' ?>>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
    </button>

    <button class="paginacao-btn" id="btn-ultima" title="Última página"
            <?= $pagina_atual === $total_paginas ? 'disabled' : '' ?>>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="13 17 18 12 13 7"></polyline>
            <polyline points="6 17 11 12 6 7"></polyline>
        </svg>
    </button>
</div>

<div class="info-paginacao" id="info-paginacao">
    Mostrando
    <span id="info-inicio"><?= $inicio ?></span>-<span id="info-fim"><?= $fim ?></span>
    de
    <span id="info-total"><?= $total_noticias ?></span> notícias
</div>

<script>
    function inicializarPaginacao() {
        const container = document.getElementById('paginacao');
        if (!container) return;

        const paginaAtual  = parseInt(container.dataset.paginaAtual);
        const totalPaginas = parseInt(container.dataset.totalPaginas);
        const endpoint     = container.dataset.endpoint;
        const target       = container.dataset.target;

        const btnPrimeira = document.getElementById('btn-primeira');
        const btnAnterior = document.getElementById('btn-anterior');
        const btnProxima  = document.getElementById('btn-proxima');
        const btnUltima   = document.getElementById('btn-ultima');

        if (btnPrimeira) btnPrimeira.addEventListener('click', () => irParaPagina(1,               endpoint, target));
        if (btnAnterior) btnAnterior.addEventListener('click', () => irParaPagina(paginaAtual - 1, endpoint, target));
        if (btnProxima)  btnProxima.addEventListener('click',  () => irParaPagina(paginaAtual + 1, endpoint, target));
        if (btnUltima)   btnUltima.addEventListener('click',   () => irParaPagina(totalPaginas,    endpoint, target));
    }

    function irParaPagina(pagina, endpoint, target) {
        const busca      = document.getElementById('busca-texto')?.value        ?? '';
        const categoria  = document.getElementById('filtro-categoria')?.value   ?? '';
        const dataInicio = document.getElementById('filtro-data-inicio')?.value ?? '';
        const dataFim    = document.getElementById('filtro-data-fim')?.value    ?? '';

        const params = new URLSearchParams({
            page:                 pagina,
            'busca-texto':        busca,
            'filtro-categoria':   categoria,
            'filtro-data-inicio': dataInicio,
            'filtro-data-fim':    dataFim,
        });

        htmx.ajax('GET', `/proxy.php?p=${endpoint}&${params.toString()}`, {
            target: target,
            swap:   'innerHTML'
        });
    }

    inicializarPaginacao(); // ← roda no carregamento direto (minhas-noticias)

    document.addEventListener('htmx:afterSwap', function (e) {
        if (e.target.id === 'noticia' || e.target.id === 'minhas-noticias') {
            inicializarPaginacao();
        }
    });
</script>