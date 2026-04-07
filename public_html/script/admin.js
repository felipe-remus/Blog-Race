// ========================================
// PAINEL ADMINISTRATIVO - ADMIN.JS
// ========================================

document.addEventListener('DOMContentLoaded', () => {

    // ========== FLASH DE SESSÃO ==========
    // Lê o flash que o PHP gravou na sessão e exibe o toast (igual ao publicar.js)
    const flashData = document.getElementById('flash-data');
    if (flashData) {
        mostrarToast(flashData.dataset.mensagem, flashData.dataset.tipo);
    }

    // ========== ABAS ==========
    const tabButtons  = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabName = btn.dataset.tab;

            tabButtons.forEach(b  => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));

            btn.classList.add('active');
            document.getElementById(`tab-${tabName}`).classList.add('active');
        });
    });

    // ========== CONFIRMAÇÃO DE DELETAR USUÁRIO ==========
    // Intercepta o submit do form de deletar para exibir modal antes de enviar
    document.addEventListener('submit', (e) => {
        const form = e.target;

        if (form.classList.contains('form-deletar')) {
            e.preventDefault();
            const nome = form.dataset.nome;

            confirmarAcao(
                'Deletar Usuário',
                `Tem certeza que deseja deletar o usuário "${nome}"? Esta ação é irreversível.`,
                () => form.submit()
            );
        }
    });

    // ========== MODAL ==========
    const modal      = document.getElementById('modalConfirmacao');
    const btnCancelar = modal.querySelector('.btn-cancelar');
    const btnFechar   = modal.querySelector('.modal-fechar');

    btnCancelar.addEventListener('click', fecharModal);
    btnFechar.addEventListener('click',   fecharModal);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) fecharModal();
    });
});

// ========================================
// FUNÇÕES - MODAL
// ========================================

function confirmarAcao(titulo, mensagem, callback) {
    const modal = document.getElementById('modalConfirmacao');
    document.getElementById('modalTitulo').textContent   = titulo;
    document.getElementById('modalMensagem').textContent = mensagem;

    // Substitui o botão confirmar para evitar listeners acumulados
    const btnConfirmar = modal.querySelector('.btn-confirmar');
    const novoBtn      = btnConfirmar.cloneNode(true);
    btnConfirmar.replaceWith(novoBtn);

    novoBtn.addEventListener('click', () => {
        fecharModal();
        callback();
    });

    modal.style.display = 'flex';
}

function fecharModal() {
    document.getElementById('modalConfirmacao').style.display = 'none';
}

// ========================================
// FUNÇÕES - FILTRO DE USUÁRIOS
// ========================================

function filtrarUsuarios(termo) {
    const linhas = document.querySelectorAll('#tabela-usuarios tr');
    const busca  = termo.toLowerCase().trim();

    linhas.forEach(tr => {
        // A coluna "Usuário" é a 2ª (índice 1) — contém o @user
        const celUser = tr.querySelector('td:nth-child(2)');
        if (!celUser) return;
        const texto = celUser.textContent.toLowerCase();
        tr.style.display = texto.includes(busca) ? '' : 'none';
    });
}

// ========================================
// FUNÇÕES - TOAST
// ========================================

function mostrarToast(mensagem, tipo = 'info') {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = mensagem;
    toast.className   = `toast ${tipo}`;
    setTimeout(() => { toast.className = 'toast'; }, 3000);
}