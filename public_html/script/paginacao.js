// ============================================================
// PAGINAÇÃO — conecta os botões ao HTMX preservando filtros
// Chamado sempre que #noticia for atualizado (contém a paginação)
// ============================================================

function inicializarPaginacao() {
    const container = document.getElementById('paginacao');
    if (!container) return;

    const paginaAtual   = parseInt(container.dataset.paginaAtual);
    const totalPaginas  = parseInt(container.dataset.totalPaginas);

    const btnPrimeira = document.getElementById('btn-primeira');
    const btnAnterior = document.getElementById('btn-anterior');
    const btnProxima  = document.getElementById('btn-proxima');
    const btnUltima   = document.getElementById('btn-ultima');

    if (btnPrimeira) btnPrimeira.addEventListener('click', () => irParaPagina(1));
    if (btnAnterior) btnAnterior.addEventListener('click', () => irParaPagina(paginaAtual - 1));
    if (btnProxima)  btnProxima.addEventListener('click',  () => irParaPagina(paginaAtual + 1));
    if (btnUltima)   btnUltima.addEventListener('click',   () => irParaPagina(totalPaginas));
}

function irParaPagina(pagina) {
    // Coleta os filtros ativos no momento
    const busca       = document.getElementById('busca-texto')?.value        ?? '';
    const categoria   = document.getElementById('filtro-categoria')?.value   ?? '';
    const dataInicio  = document.getElementById('filtro-data-inicio')?.value ?? '';
    const dataFim     = document.getElementById('filtro-data-fim')?.value    ?? '';

    // Monta a query string com página + filtros
    const params = new URLSearchParams({
        page: pagina,
        'busca-texto':         busca,
        'filtro-categoria':    categoria,
        'filtro-data-inicio':  dataInicio,
        'filtro-data-fim':     dataFim,
    });

    // Dispara HTMX apontando para o mesmo endpoint do carregamento inicial
    htmx.ajax('GET', `/proxy.php?p=model_noticia&${params.toString()}`, {
        target: '#noticia',
        swap:   'innerHTML'
    });
}

// ─── Gatilho: roda sempre que #noticia for reinjetado pelo HTMX ───
document.addEventListener('htmx:afterSwap', function (e) {
    if (e.target.id === 'noticia') {
        inicializarPaginacao();
    }
});