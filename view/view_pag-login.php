<?php
session_start();

$usuarioLogado       = isset($_SESSION['usuario']);
$deve_trocar_senha   = !empty($_SESSION['must_change_password']);

// Lê e limpa o flash de sessão
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<main class="pagina-login">
    <div class="login-container">

        <?php if ($deve_trocar_senha): ?>
            <!-- MODO RESTRITO: só troca de senha -->
            <div class="perfil-usuario">
                <h2>Defina sua Senha</h2>
                <p class="bem-vindo aviso-senha-padrao">
                        Sua senha é a padrão do sistema.<br>
                    <strong>Defina uma senha pessoal para continuar.</strong>
                </p>

                <form id="form-trocar-senha"
                    class="formulario ativo"
                    method="POST"
                    action="login.php">

                    <input type="hidden" name="acao"  value="editar">
                    <!-- Campos obrigatórios pelo model, preenchidos silenciosamente -->
                    <input type="hidden" name="nome"  value="<?= htmlspecialchars($_SESSION['usuario']['nome'])  ?>">
                    <input type="hidden" name="user"  value="<?= htmlspecialchars($_SESSION['usuario']['user'])  ?>">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($_SESSION['usuario']['email']) ?>">
                    <input type="hidden" name="telefone" value="<?= htmlspecialchars($_SESSION['usuario']['telefone'] ?? '') ?>">

                    <div class="campo">
                        <label for="senha-atual">Senha Atual (padrão do sistema)</label>
                        <input type="password" id="senha-atual" name="senha_atual" required>
                    </div>

                    <div class="campo">
                        <label for="senha-nova">Nova Senha</label>
                        <input type="password" id="senha-nova" name="senha_nova" required minlength="6">
                    </div>

                    <div class="campo">
                        <label for="confirmar-senha-nova">Confirmar Nova Senha</label>
                        <input type="password" id="confirmar-senha-nova" name="confirmar_senha_nova" required>
                    </div>

                    <button type="submit" class="botao-de-login">Definir Senha</button>
                </form>
            </div>

        <?php elseif ($usuarioLogado): ?>
            <div class="perfil-usuario">
                <h2>Alterar Meu Perfil</h2>
                <p class="bem-vindo">Bem-vindo, <strong><?= htmlspecialchars($_SESSION['usuario']['nome']) ?></strong>!</p>

                <form id="form-editar-perfil"
                    class="formulario ativo"
                    method="POST"
                    action="login.php">

                    <input type="hidden" name="acao" value="editar">

                    <div class="campo">
                        <label for="nome-perfil">Nome Completo</label>
                        <input type="text" id="nome-perfil" name="nome"
                            value="<?= htmlspecialchars($_SESSION['usuario']['nome']) ?>" required>
                    </div>

                    <div class="campo">
                        <label for="usuario-perfil">Nome de Usuário</label>
                        <input type="text" id="usuario-perfil" name="user"
                            value="<?= htmlspecialchars($_SESSION['usuario']['user']) ?>" required>
                    </div>

                    <div class="campo">
                        <label for="email-perfil">Email</label>
                        <input type="email" id="email-perfil" name="email"
                            value="<?= htmlspecialchars($_SESSION['usuario']['email']) ?>" required>
                    </div>

                    <div class="campo">
                        <label for="telefone-perfil">Telefone</label>
                        <input type="tel" id="telefone-perfil" name="telefone"
                            value="<?= htmlspecialchars($_SESSION['usuario']['telefone']) ?>"
                            placeholder="(00) 00000-0000">
                    </div>

                    <fieldset class="fieldset-senha">
                        <legend>Alterar Senha (Opcional)</legend>
                        <p class="info-senha">Deixe em branco se não desejar alterar a senha</p>

                        <div class="campo">
                            <label for="senha-atual">Senha Atual</label>
                            <input type="password" id="senha-atual" name="senha_atual">
                        </div>

                        <div class="campo">
                            <label for="senha-nova">Senha Nova</label>
                            <input type="password" id="senha-nova" name="senha_nova">
                        </div>

                        <div class="campo">
                            <label for="confirmar-senha-nova">Confirmar Senha Nova</label>
                            <input type="password" id="confirmar-senha-nova" name="confirmar_senha_nova">
                        </div>
                    </fieldset>

                    <div class="grupo-botoes">
                        <button type="submit" class="botao-de-login">Salvar Alterações</button>
                        <button type="button" class="botao-deletar-conta" onclick="abrirModalDeletarConta()">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                <line x1="10" y1="11" x2="10" y2="17"/>
                                <line x1="14" y1="11" x2="14" y2="17"/>
                            </svg>
                            Deletar Minha Conta
                        </button>
                    </div>
                </form>

                <!-- MODAL CONFIRMAR DELETAR CONTA -->
                <div class="modal-confirmacao" id="modalDeletarConta" style="display:none;">
                    <div class="modal-conteudo">
                        <button class="modal-fechar" type="button" onclick="fecharModalDeletarConta()">&times;</button>
                        <h3>Deletar Conta</h3>
                        <p>Tem certeza que deseja deletar sua conta? <strong>Esta ação é irreversível.</strong></p>
                        
                        <!--<input type="hidden" name="acao" value="deletar_conta">-->
                        <div class="modal-botoes">
                            <button class="btn-modal btn-cancelar" onclick="fecharModalDeletarConta()">Cancelar</button>
                            <a href="actions/usuario-apagar.php?id_usuario=<?=$_SESSION['usuario']['id_usuario']?>" class="btn-modal btn-confirmar-deletar">Sim, deletar</a>
                        </div>
                    
                    </div>
                </div>

                <script>
                    function abrirModalDeletarConta()  { document.getElementById('modalDeletarConta').style.display = 'flex'; }
                    function fecharModalDeletarConta() { document.getElementById('modalDeletarConta').style.display = 'none'; }
                    document.getElementById('modalDeletarConta').addEventListener('click', function(e) {
                        if (e.target === this) fecharModalDeletarConta();
                    });
                </script>
            </div>

        <?php else: ?>
            <div class="abas-login">
                <button type="button"
                        class="aba"
                        >Entrar</button>
            </div>

            <form id="form-login"
                class="formulario-ativo"
                method="POST"
                action="login.php">

                <input type="hidden" name="acao" value="login">

                <div class="campo">
                    <label for="email-login">Email ou Nome de Usuário</label>
                    <input id="email-login" name="email_login" required>
                </div>

                <div class="campo campo-senha">
                    <label for="senha-login">Senha</label>
                    <input type="password" id="senha-login" name="senha_login" required>
                    <button type="button" class="btn-mostrar-senha" onclick="toggleSenha(this)">
                        <svg class="icone-olho-aberto" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        <svg class="icone-olho-fechado" viewBox="0 0 24 24" style="display:none"><path d="M11.83 9L15 12.17V12c0-1.66-1.34-3-3-3h-.17zm-4.27.55L6.39 8.38C4.65 9.65 3.29 11.27 2.5 13.25c1.73 4.39 6 7.5 11 7.5 2.07 0 4.04-.51 5.77-1.41l-1.56-1.56C16.65 18.45 15.38 19 14 19c-3.87 0-7-3.13-7-7 0-.68.1-1.33.28-1.95zM12 6c3.79 0 7.17 2.13 8.82 5.5C20.97 11.17 21.19 10.83 21.5 10.5c-1.73-4.39-6-7.5-11-7.5-2.07 0-4.04.51-5.77 1.41L6.29 5.96C8.03 5.06 10 4.55 12 4.55zM1.27 4.21l1.41 1.41L4.22 7.17C3.07 8.55 2.19 10.22 1.5 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l4.5 4.5 1.41-1.41L1.27 4.21z"/></svg>
                    </button>
                </div>

                <button type="submit" class="botao-de-login">Entrar</button>
            </form>
        <?php endif; ?>

        <!-- Flash de sessão: PHP escreve os dados, JS exibe o toast -->
        <?php if ($flash): ?>
            <div id="flash-data"
                data-mensagem="<?= htmlspecialchars($flash['mensagem']) ?>"
                data-tipo="<?= htmlspecialchars($flash['tipo']) ?>"
                style="display:none"></div>
        <?php endif; ?>

        <!-- Toast para mensagens -->
        <div id="toast" class="toast"></div>
    </div>
</main>