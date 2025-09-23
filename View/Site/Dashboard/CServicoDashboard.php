<main>
    <?php if(isset($_SESSION['error'])): ?>
        <div id="modal-container" class="modal-container">
            <div class="modal">
                <div class="modalContainerTitle">
                    <h3 class="modalTitle">
                        <?= htmlspecialchars($_SESSION['errorTitle']) ?>
                    </h3>
                </div>
                <div class="modalContainerMessage">
                    <p class="modalMessage">
                        <?= htmlspecialchars($_SESSION['error']) ?>
                    </p>
                </div>
                <div class="modalButton">
                    <button onclick="fecharModal()">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
        <div id="modal-overlay" class="modal-overlay"></div>
    <?php unset($_SESSION['errorTitle']); ?>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <div id="modalConfirmacao" class="modal-container" style="display:none;">
        <div class="modal">
            <div class="modalContainerTitle">
                <h3 class="modalTitle">Confirmar Exclusão</h3>
            </div>
            <div class="modalContainerMessage">
                <p class="modalMessage">Tem certeza que deseja excluir este serviço?</p>
            </div>
            <div class="modalDualButton">
                <button id="btnCancelar">Cancelar</button>
                <button id="btnConfirmar">Excluir</button>
            </div>
        </div>
    </div>
    <div id="modal-overlay" class="modal-overlay" style="display:none;"></div>
    <section class="pageContainer">
        <section class="dashboard-section">
            <section class="dashboard-container contentBox">
                <a href="/dashboard" class="nav-button" aria-label="Anterior">
                    «
                </a>
                <div class="dashboard">
                    <h2 class="dashboard-title">Dashboard de Categorias de Serviço</h2>

                    <h3 class="dashboard-title">Crie uma Categoria de Serviço, liste serviços, edite serviços ou exclua serviços.</h3>

                    <?php if(!empty($cservicos)): ?>
                    <table class="dashboard-budget-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Serviço</th>
                                    <th>Descrição</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cservicos as $cservico): ?>
                                <tr>
                                    <td><a class="btn_delete" onclick="confirmarExclusao(<?= $cservico->getIdCategoriaServico() ?>)">X</a></td>
                                    <td><?= htmlspecialchars($cservico->getNomeCategoriaServico()) ?></td>
                                    <td><?= htmlspecialchars($cservico->getDescricaoCategoriaServico()) ?></td>
                                    <td><a href="/dashboard/servico/form?id=<?= $cservico->getIdCategoriaServico() ?>">Editar</a></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                    </table>
                    <h3 class="dashboard-title">Deseja cadastrar mais categoria de serviços?</h3>
                    <a class="btn-add" href="/dashboard/servico/form">
                        Cadastrar Serviço
                    </a>
                    <?php else: ?> 
                            <h3 class="dashboard-title">Nenhum registro foi encontrado.</h3>
                            <a class="btn-add" href="/dashboard/servico/form">
                                Cadastrar Serviço
                            </a>
                    <?php endif ?>
                </div>
            </section>
        </section>
    </section>
</main>