// ========================================
// PAINEL ADMINISTRATIVO - ADMIN.JS
// ========================================

document.addEventListener('DOMContentLoaded', () => {

    // ========== FLASH DE SESSÃO ==========
    // Lê o flash gravado pelo PHP na sessão e exibe o toast (igual ao login.js)
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

    // ========== MÁSCARA DE TELEFONE ==========
    document.querySelectorAll('input[type="tel"]').forEach(input => aplicarMascaraTelefone(input));

    // ========== FORM DELETAR — submit → modal → fetch + flash ==========
    // FIX: seletor corrigido de form[data-deletar] → .form-deletar
    document.querySelectorAll('.form-deletar').forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const nome = form.dataset.nome;

            confirmarAcao(
                'Deletar Usuário',
                `Tem certeza que deseja deletar o usuário "${nome}"? Esta ação é irreversível.`,
                async () => {
                    try {
                        await fetch('admin.php', {
                            method: 'POST',
                            body: new FormData(form),
                            redirect: 'manual'
                        });
                        await exibirFlash(() => location.reload());
                    } catch (err) {
                        mostrarToast('Erro de conexão.', 'erro');
                    }
                }
            );
        });
    });

    // ========== FORM PERFIL — change no select → fetch + flash ==========
    // FIX: form.submit() nativo não dispara o evento 'submit', então interceptamos
    //      o 'change' diretamente no <select> e removemos o onchange inline do HTML.
    // FIX: seletor corrigido de form[data-perfil] → .form-perfil
    document.querySelectorAll('.form-perfil select').forEach(select => {
        select.addEventListener('change', async () => {
            const form = select.closest('form');
            try {
                await fetch('admin.php', {
                    method: 'POST',
                    body: new FormData(form),
                    redirect: 'manual'
                });
                await exibirFlash(() => location.reload());
            } catch (err) {
                mostrarToast('Erro de conexão.', 'erro');
            }
        });
    });

    // ========== FORM REGISTRO (CRIAR USUÁRIO) — submit → fetch + flash ==========
    // FIX: no admin o view é incluído diretamente (sem HTMX), então o htmx:afterSwap
    //      do login.js nunca dispara — o form ficava submetendo nativamente.
    const formRegistro = document.getElementById('form-registro');
    if (formRegistro) {
        formRegistro.addEventListener('submit', handleFormRegistro);
    }

    // ========== MODAL ==========
    const modal       = document.getElementById('modalConfirmacao');
    const btnCancelar = modal.querySelector('.btn-cancelar');
    const btnFechar   = modal.querySelector('.modal-fechar');

    btnCancelar.addEventListener('click', fecharModal);
    btnFechar.addEventListener('click',   fecharModal);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) fecharModal();
    });
});

// ========================================
// HANDLER — form-registro (criar usuário)
// Espelha o handleFormSubmit do login.js
// ========================================
async function handleFormRegistro(e) {
    e.preventDefault();
    const form = e.target;

    try {
        await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            redirect: 'manual'
        });

        const flashRes = await fetch('includes/get_flash.php', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const flash = await flashRes.json();

        if (!flash) return; // sem flash: não faz nada (igual ao login.js)

        if (flash.tipo === 'erro') {
            mostrarToast(flash.mensagem, 'erro');
            return; // erro: apenas toast, sem recarregar
        }

        // Sucesso: toast + reload
        mostrarToast(flash.mensagem, 'sucesso');
        setTimeout(() => location.reload(), 800);

    } catch (err) {
        mostrarToast('Erro de conexão. Tente novamente.', 'erro');
    }
}

// ========================================
// HELPER — lê flash da sessão e age conforme o tipo
// FIX: flash nulo → return silencioso (igual ao login.js)
//      Antes: exibia 'Ação realizada!' e recarregava mesmo sem flash.
// ========================================
async function exibirFlash(onSucesso) {
    try {
        const flashRes = await fetch('includes/get_flash.php', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const flash = await flashRes.json();

        if (!flash) return; // sem flash: não faz nada

        mostrarToast(flash.mensagem, flash.tipo);

        if (flash.tipo !== 'erro') {
            setTimeout(onSucesso, 800); // sucesso: executa callback após toast
        }
        // erro: apenas toast, sem callback (sem reload)

    } catch {
        location.reload(); // fallback se não conseguir ler o flash
    }
}

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