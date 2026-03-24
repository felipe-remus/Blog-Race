<main class="pagina-login">
    <div class="login-container">
        <!-- Abas -->
        <div class="abas-login">
            <button type="button" class="aba ativa" data-aba="login">Entrar</button>
            <button type="button" class="aba" data-aba="registro">Criar Conta</button>
        </div>

        <!-- Login -->
        <form id="form-login" class="formulario ativo">
            <div class="campo">
                <label for="email-login">Email ou Nome de Usuário</label>
                <input id="email-login" name="email_login" required>
            </div>
            <div class="campo">
                <label for="senha-login">Senha</label>
                <input type="password" id="senha-login" name="senha_login" required>
            </div>
            <button type="submit" class="botao-de-login">Entrar</button>
        </form>

        <!-- Registro -->
        <form id="form-registro" class="formulario" method="POST">
            <div class="campo">
                <label for="nome-registro">Nome</label>
                <input name="nome_registro" type="text" id="nome-registro" required>
            </div>
            <div class="campo">
                <label for="usuario-registro">Nome de Usuário</label>
                <input name="user_registro" type="text" id="usuario-registro" required>
            </div>
            <div class="campo">
                <label for="email-registro">Email</label>
                <input name="email_registro" type="email" id="email-registro" required>
            </div>

            <div class="campo-linha">
                <div class="subcampo">
                    <label for="telefone-registro">Telefone</label>
                    <input name="fone_registro" type="tel" id="telefone-registro" placeholder="(00) 00000-0000">
                </div>
            </div>
            <div class="campo">
                <label for="senha-registro">Senha</label>
                <input name="senha_registro" type="password" id="senha-registro" required>
            </div>
            <div class="campo">
                <label for="confirmar-senha">Confirmar Senha</label>
                <input name="confirmar_senha_registro" type="password" id="confirmar-senha" required>
            </div>
            <button type="submit" class="botao-de-login">Criar Conta</button>
        </form>

        <!-- Toast para mensagens -->
        <div id="toast" class="toast"></div>
    </div>

<script>
// ========================================
// MÁSCARA DE TELEFONE
// ========================================
document.getElementById('telefone-registro').addEventListener('input', function(e) {
    var value = e.target.value;
    var telPattern = value.replace(/\D/g, '')
                        .replace(/(\d{2})(\d)/, '($1) $2')
                        .replace(/(\(\d{2}\) \s\d{5})(\d)/, '$1-$2')
                        .replace(/(-\d{4})\d+?$/, '$1');        
    e.target.value = telPattern;
});

// ========================================
// FUNÇÃO MOSTRAR TOAST
// ========================================
function mostrarToast(mensagem, tipo = 'info') {
    const toast = document.getElementById('toast');
    toast.textContent = mensagem;
    toast.className = `toast ${tipo}`;
    
    setTimeout(() => {
        toast.classList.add(tipo);
    }, 10);

    setTimeout(() => {
        toast.classList.remove(tipo);
    }, 3000);
}

// ========================================
// FUNÇÃO ENVIAR REQUISIÇÃO
// ========================================
function enviarRequisicao(formData, endpoint, callback) {
    fetch(endpoint, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => callback(data))
    .catch(error => {
        console.error('Erro:', error);
        mostrarToast('Erro ao processar requisição', 'erro');
    });
}

// ========================================
// SUBMIT DO FORMULÁRIO DE LOGIN
// ========================================
document.getElementById('form-login').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    enviarRequisicao(formData, 'model_login.php', (resposta) => {
        if (resposta.sucesso) {
            mostrarToast(resposta.mensagem, 'sucesso');
            document.getElementById('form-login').reset();
            
            // Redirecionar após 1 segundo
            setTimeout(() => {
                window.location.href = 'index.html';
            }, 1000);
        } else {
            mostrarToast(resposta.mensagem, 'erro');
        }
    });
});

// ========================================
// SUBMIT DO FORMULÁRIO DE REGISTRO
// ========================================
document.getElementById('form-registro').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const senha = document.getElementById('senha-registro').value;
    const confirmarSenha = document.getElementById('confirmar-senha').value;
    
    // Validação client-side
    if (senha !== confirmarSenha) {
        mostrarToast('As senhas não coincidem', 'erro');
        return;
    }
    
    if (senha.length < 6) {
        mostrarToast('Senha deve ter no mínimo 6 caracteres', 'erro');
        return;
    }
    
    const formData = new FormData(this);
    
    enviarRequisicao(formData, 'model_registro.php', (resposta) => {
        if (resposta.sucesso) {
            mostrarToast(resposta.mensagem, 'sucesso');
            document.getElementById('form-registro').reset();
            
            // Redirecionar após 1 segundo
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 1000);
        } else {
            mostrarToast(resposta.mensagem, 'erro');
        }
    });
});

// ========================================
// ALTERNAR ENTRE ABAS (Login/Registro)
// ========================================
document.querySelectorAll('.aba').forEach(aba => {
    aba.addEventListener('click', function() {
        const abaAlvo = this.dataset.aba;
        
        // Remove class ativa de todas as abas
        document.querySelectorAll('.aba').forEach(a => a.classList.remove('ativa'));
        document.querySelectorAll('.formulario').forEach(f => f.classList.remove('ativo'));
        
        // Adiciona class ativa na aba clicada
        this.classList.add('ativa');
        document.getElementById('form-' + abaAlvo).classList.add('ativo');
    });
});
</script>