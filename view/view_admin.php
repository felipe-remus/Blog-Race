<main>
    <!-- CABEÇALHO DO ADMIN -->
    <div class="titulo-principal">
        <h1>Gerenciamento de categorias e usuários</h1>
    </div>
    
    <!-- ESTATÍSTICAS -->
    <div class="admin-stats">
        <div class="stat-card">
            <div class="stat-icon usuarios">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Usuários</span>
                <span class="stat-valor"><?= $stats['total_usuarios'] ?></span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon categorias">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Categorias</span>
                <span class="stat-valor"><?= $stats['total_categorias'] ?></span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon noticias">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16v12H4z"/>
                    <path d="M4 16h16v4H4z"/>
                    <line x1="4" y1="9" x2="20" y2="9"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Notícias Totais</span>
                <span class="stat-valor"><?= $stats['total_noticias'] ?></span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon hoje">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Hoje</span>
                <span class="stat-valor"><?= $stats['noticias_hoje'] ?></span>
            </div>
        </div>
    </div>

    <!-- ABAS DE NAVEGAÇÃO -->
    <div class="admin-tabs">
        <button class="tab-btn active" data-tab="categorias">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
            </svg>
            Categorias
        </button>
        <button class="tab-btn" data-tab="usuarios">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Usuários
        </button>
    </div>

    <!-- ========== ABA CATEGORIAS ========== -->
    <div class="tab-content active" id="tab-categorias">
        <div class="admin-container">
            <div class="admin-table-section">
                <h2>Categorias</h2>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Sigla</th>
                            </tr>
                        </thead>
                        <tbody id="tabela-categorias">
                            <?php foreach ($categorias as $cat): ?>
                                <tr data-id="<?= $cat['id_categoria'] ?>">
                                    <td><?= htmlspecialchars($cat['nome_categoria']) ?></td>
                                    <td><span class="badge"><?= htmlspecialchars($cat['sigla_categoria']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== ABA USUÁRIOS ========== -->
    <div class="tab-content" id="tab-usuarios">
        <div class="admin-container">
            <div class="admin-table-section">
                <h2>Usuários do Sistema</h2>

                <!-- FILTRO POR USUÁRIO -->
                <div class="filtro-usuario">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input
                        type="text"
                        id="filtro-user"
                        placeholder="Filtrar por usuário..."
                        oninput="filtrarUsuarios(this.value)">
                </div>

                <div class="table-responsive">
                    <table class="admin-table usuarios-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Usuário</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Perfil</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabela-usuarios">
                            <?php foreach ($usuarios as $user): ?>
                                <tr data-id="<?= $user['id_usuario'] ?>">
                                    <td><?= htmlspecialchars($user['nome']) ?></td>
                                    <td><span class="badge-user">@<?= htmlspecialchars($user['user']) ?></span></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['telefone'] ?? '-') ?></td>
                                    <td>
                                        <!-- Formulário inline para troca de perfil (POST nativo, sem JSON) -->
                                        <form method="POST" action="admin.php" class="form-perfil">
                                            <input type="hidden" name="acao" value="atualizar_perfil">
                                            <input type="hidden" name="id_usuario" value="<?= $user['id_usuario'] ?>">
                                            <select
                                                name="perfil_id"
                                                class="select-perfil"
                                                data-perfil-atual="<?= $user['id_perfil'] ?>"
                                                onchange="this.form.submit()">
                                                <?php foreach ($perfis as $perfil): ?>
                                                    <option
                                                        value="<?= $perfil['id_perfil'] ?>"
                                                        <?= $perfil['id_perfil'] == $user['id_perfil'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($perfil['nome_perfil']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <?php $e_voce = ($user['id_usuario'] == $_SESSION['usuario']['id_usuario']); ?>
                                        <!-- Formulário inline para deletar usuário (POST nativo, sem JSON) -->
                                        <form method="POST" action="admin.php"
                                            class="<?= $e_voce ? '' : 'form-deletar' ?>"
                                            data-nome="<?= htmlspecialchars($user['nome']) ?>">
                                            <input type="hidden" name="acao" value="deletar_usuario">
                                            <input type="hidden" name="id_usuario" value="<?= $user['id_usuario'] ?>">
                                            <button
                                                type="<?= $e_voce ? 'button' : 'submit' ?>"
                                                class="btn-acao btn-deletar-usuario<?= $e_voce ? ' btn-deletar-desabilitado' : '' ?>"
                                                title="<?= $e_voce ? 'Você não pode deletar sua própria conta' : 'Deletar usuário' ?>"
                                                <?= $e_voce ? 'disabled' : '' ?>>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"/>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                    <line x1="10" y1="11" x2="10" y2="17"/>
                                                    <line x1="14" y1="11" x2="14" y2="17"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MODAL DE CONFIRMAÇÃO (deletar usuário) -->
<div class="modal-confirmacao" id="modalConfirmacao" style="display: none;">
    <div class="modal-conteudo">
        <button class="modal-fechar" type="button">&times;</button>
        <h3 id="modalTitulo">Confirmar ação</h3>
        <p id="modalMensagem">Tem certeza que deseja continuar?</p>
        <div class="modal-botoes">
            <button class="btn-admin btn-cancelar" type="button">Cancelar</button>
            <button class="btn-admin btn-confirmar" type="button">Confirmar</button>
        </div>
    </div>
</div>

<!-- Flash de sessão: PHP escreve os dados, JS exibe o toast -->
<?php if ($flash): ?>
    <div id="flash-data"
        data-mensagem="<?= htmlspecialchars($flash['mensagem']) ?>"
        data-tipo="<?= htmlspecialchars($flash['tipo']) ?>"
        style="display:none"></div>
<?php endif; ?>

<!-- Toast para mensagens -->
<div id="toast" class="toast"></div>