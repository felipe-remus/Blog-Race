<?php
$perfilUsuario = $_SESSION['usuario']['perfil_id'];
?>

<div id="noticias-container" class="noticias-container">

<?php if ($total_noticias === 0): ?>
    <div class="sem-noticias">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.5">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="12" y1="18" x2="12" y2="12"/>
            <line x1="9" y1="15" x2="15" y2="15"/>
        </svg>
        <p>Você ainda não publicou nenhuma notícia.</p>
        <a href="escrever-noticia.php" class="btn-acao">Criar minha primeira notícia</a>
    </div>

<?php else: ?>

    <?php while ($uma_noticia = $noticias->fetch(PDO::FETCH_ASSOC)):
        $titulo_noticia = $uma_noticia['titulo_noticia'];
        $texto_noticia  = $uma_noticia['texto_noticia'];
        $data_noticia   = date('d/m/Y', strtotime($uma_noticia['data_noticia']));
        $autor          = $uma_noticia['autor'];
        $tag_categoria  = $uma_noticia['nome_categoria'];
        $imagem_noticia = $uma_noticia['imagem_noticia'];
        $id_noticia     = $uma_noticia['id_noticia'];

        // Na página "Minhas Notícias" o usuário sempre pode editar e deletar
        // Admin também pode deletar qualquer notícia aqui
        $podeEditar  = true;
        $podeDeletar = true;
    ?>
        <article class="card-noticia"
            data-data="<?= $data_noticia ?>"
            data-categoria="<?= $tag_categoria ?>">

            <div class="card-imagem">
                <img src="<?= $imagem_noticia ?>"
                    loading="lazy"
                    alt="<?= htmlspecialchars($titulo_noticia) ?>">
                <span class="card-imagem-badge"><?= $tag_categoria ?></span>
            </div>

            <div class="card-body">
                <div class="card-header">
                    <h2><?= htmlspecialchars($titulo_noticia) ?></h2>
                    <p class="meta">
                        <svg class="meta-icon" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <?= $data_noticia ?>
                        <span class="separador">•</span>
                        <svg class="meta-icon" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <?= htmlspecialchars($autor) ?>
                    </p>
                </div>

                <p class="card-conteudo"><?= htmlspecialchars($texto_noticia) ?></p>

                <div class="card-acoes">
                    <a class="btn-acao"
                        aria-label="Editar notícia"
                        title="Editar"
                        href="editar-noticia.php?id_noticia=<?= $id_noticia ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L21 6.5z"/>
                        </svg>
                        Editar
                    </a>

                    <a class="btn-acao btn-deletar"
                        aria-label="Deletar notícia"
                        title="Deletar"
                        href="actions/noticia-apagar.php?id_noticia=<?= $id_noticia ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            <line x1="10" y1="11" x2="10" y2="17"/>
                            <line x1="14" y1="11" x2="14" y2="17"/>
                        </svg>
                        Deletar
                    </a>
                </div>
            </div>
        </article>
    <?php endwhile; ?>

<?php endif; ?>
</div>

<div class="modal-overlay" id="modalOverlay" role="dialog" aria-modal="true" aria-label="Notícia expandida">
    <div class="modal-card" id="modalCard">
        <button class="modal-fechar" id="modalFechar" aria-label="Fechar">&#x2715;</button>
    </div>
</div>

<script>
    function fecharModal() {
        const overlay = document.getElementById('modalOverlay');
        if (!overlay) return;
        overlay.classList.remove('ativo');
        document.body.classList.remove('modal-aberto');
    }

    function inicializarModal() {
        const overlay   = document.getElementById('modalOverlay');
        const modalCard = document.getElementById('modalCard');
        const btnFechar = document.getElementById('modalFechar');

        if (!overlay || !modalCard || !btnFechar) return;

        function abrirModal(card) {
            const clone = card.cloneNode(true);

            // Limpa conteúdo anterior (mantém só o botão fechar)
            while (modalCard.children.length > 1) {
                modalCard.removeChild(modalCard.lastChild);
            }

            Array.from(clone.children).forEach(el => modalCard.appendChild(el));

            overlay.classList.add('ativo');
            document.body.classList.add('modal-aberto');
            btnFechar.focus();
        }

        // Vincula clique nos cards
        document.querySelectorAll('.card-noticia').forEach(card => {
            card.addEventListener('click', (e) => {
                // Previne abrir o modal se clicou nos botões de ação
                if (e.target.closest('.btn-acao') || e.target.closest('.card-acoes')) {
                    return;
                }
                abrirModal(card);
            });
        });

        btnFechar.onclick = fecharModal;

        overlay.addEventListener('click', e => {
            if (e.target === overlay) fecharModal();
        });
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') fecharModal();
    });

    document.addEventListener('htmx:afterSwap', e => {
        if (e.detail.target.id === 'noticia' ||
            e.detail.target.classList.contains('noticias-container') ||
            e.detail.target.querySelector('.card-noticia')) {
            setTimeout(inicializarModal, 50);
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(inicializarModal, 100);
    });
</script>