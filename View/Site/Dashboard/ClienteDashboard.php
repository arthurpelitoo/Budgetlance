
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
                <a href="/dashboard" class="nav-button" aria-label="Anterior">
                    «
                </a>
                <div class="dashboard">
                    <h2 class="dashboard-title">Dashboard de Clientes</h2>

                    <h3 class="dashboard-title">Crie um cliente, liste clientes, edite clientes ou exclua clientes.</h3>

                    <?php if(!empty($clientes)): ?>

                    <form class="search-form" method="get" action="/dashboard/cliente">
                        <h4 class="text-form">Pesquise usando filtros para listagens precisas!</h4>
                        <div class="search-form-div">
                            <div class="search-group">
                                <input class="input_form" type="text" name="pesquisa" placeholder="Pesquisar..." >
                                <select class="select_form" name="filtro">
                                    <option value="">Filtrar por:</option>
                                    <option value="nome">Nome</option>
                                    <option value="telefone">Telefone</option>
                                    <option value="email">Email</option>
                                </select>
                                <button class="btn_form" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                    </form>

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
                                <tr
                                    onclick="openFullScreen(this)"
                                    data-key="<?= htmlspecialchars($cliente->getIdCliente()) ?>"
                                    data-nome="<?= htmlspecialchars($cliente->getNomeCliente()) ?>"
                                    data-telefone="<?= htmlspecialchars($cliente->getTelefoneCliente()) ?>"
                                    data-email="<?= htmlspecialchars($cliente->getEmailCliente()) ?>"
                                >
                                    <td><a class="btn_delete" onclick="confirmarExclusao(<?= htmlspecialchars($cliente->getIdCliente()) ?>)"><i class="fa-solid fa-xmark"></i></a></td>
                                    <td><?= htmlspecialchars($cliente->getNomeCliente()) ?></td>
                                    <td><?= htmlspecialchars($cliente->getTelefoneCliente()) ?></td>
                                    <td><?= htmlspecialchars($cliente->getEmailCliente()) ?></td>
                                    <td><a href="/dashboard/cliente/form?id=<?= htmlspecialchars($cliente->getIdCliente()) ?>">Editar</a></td>
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
                            <a class="btn-add" href="/dashboard/cliente/form">
                                Cadastrar Cliente
                            </a>
                    <?php endif ?>
                </div>
            </section>
        </section>
    </section>
</main>
<div id="fullscreen-container" style="display: none;">
    <div class="contentBox" id="fullscreen-details">
        <div class="title-details">
            <h2 class="text-information">Detalhamento do Cliente</h2>
            <a class="closeIcon" onclick="closeFullScreen()"><i class="fa-solid fa-xmark"></i></a>
        </div>
        <div class="container-details">
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-pen-to-square"></i>
                    <h2 class="text-details">Nome do Cliente:</h2>
                </div>
                <h3 class="small-text" id="nome"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-mobile"></i>
                    <h2 class="text-details">Telefone do Cliente:</h2>
                </div>
                <h3 class="small-text" id="telefone"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-envelope"></i>
                    <h2 class="text-details">Email do Cliente:</h2>
                </div>
                <h3 class="small-text" id="email"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-file-pen"></i>
                    <h2 class="text-details">Deseja editar o Cliente?</h2>
                </div>
                <a class="btn-add" id="editar">Editar Cliente</a>
            </div>
        </div>
    </div>
</div>