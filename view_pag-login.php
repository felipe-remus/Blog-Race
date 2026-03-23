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
                <input id="email-login" required>
            </div>
            <div class="campo">
                <label for="senha-login">Senha</label>
                <input type="password" id="senha-login" required>
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
    // FUNÇÃO MOstrar Toast (Igual ao Admin)
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
    // ENVIA REQUISIÇÃO (Igual ao Admin)
    // ========================================
    function enviarRequisicao(formData, callback) {
        fetch('model_registro.php', {
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
        
        enviarRequisicao(formData, (resposta) => {
            if (resposta.sucesso) {
                mostrarToast(resposta.mensagem, 'sucesso');
                document.getElementById('form-registro').reset();
                
                // Redirecionar após 1 segundo
                setTimeout(() => {
                    window.location.href = 'login.html';
                },1000);
            } else {
                mostrarToast(resposta.mensagem, 'erro');
            }
        });
    });
    </script>