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
                <p class="modalMessage">Tem certeza que deseja excluir este cliente?</p>
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
                <div class="dashboard">
                    <h2 class="dashboard-title">Dashboard de Clientes</h2>

                    <h3 class="dashboard-title">Crie um cliente, liste clientes, edite clientes ou exclua clientes.</h3>

                    <?php if(!empty($clientes)): ?>
                    <table class="dashboard-budget-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Cliente</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($clientes as $cliente): ?>
                                <tr>
                                    <td><a onclick="confirmarExclusao(<?= $cliente->getIdCliente() ?>)">X</a></td>
                                    <td><?= htmlspecialchars($cliente->getNomeCliente()) ?></td>
                                    <td><?= htmlspecialchars($cliente->getTelefoneCliente()) ?></td>
                                    <td><?= htmlspecialchars($cliente->getEmailCliente()) ?></td>
                                    <td><a href="/dashboard/cliente/form?id=<?= $cliente->getIdCliente() ?>">Editar</a></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                    </table>
                    <h3 class="dashboard-title">Deseja cadastrar mais clientes?</h3>
                    <a class="btn-add" href="/dashboard/cliente/form">
                        Cadastrar Cliente
                    </a>
                    <?php else: ?> 
                            <h3 class="dashboard-title">Nenhum registro foi encontrado.</h3>
                            <a href="/dashboard/cliente/form">
                                Cadastrar Cliente
                            </a>
                    <?php endif ?>
                </div>
            </section>
        </section>
    </section>
</main>