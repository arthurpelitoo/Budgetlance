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

                    <form class="search-form" method="get" action="/dashboard/servico">
                        <h4 class="text-form">Pesquise usando filtros para listagens precisas!</h4>
                        <div class="search-form-div">
                            <div class="search-group">
                                <input class="input_form" type="text" name="pesquisa" placeholder="Pesquisar..." >
                                <select class="select_form" name="filtro">
                                    <option value="">Filtrar por:</option>
                                    <option value="nome">Nome do Serviço</option>
                                    <option value="descricao">Descrição</option>
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
                                    <th>Serviço</th>
                                    <th>Descrição</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cservicos as $cservico): ?>
                                <tr
                                    onclick="openFullScreen(this)"
                                    data-key="<?= htmlspecialchars($cservico->getIdCategoriaServico()) ?>"
                                    data-nome="<?= htmlspecialchars($cservico->getNomeCategoriaServico()) ?>"
                                    data-descricao="<?= htmlspecialchars($cservico->getDescricaoCategoriaServico()) ?>"
                                >
                                    <td><a class="btn_delete" onclick="confirmarExclusao(<?= htmlspecialchars($cservico->getIdCategoriaServico()) ?>)"><i class="fa-solid fa-xmark"></i></a></td>
                                    <td><?= htmlspecialchars($cservico->getNomeCategoriaServico()) ?></td>
                                    <td><?= htmlspecialchars($cservico->getDescricaoCategoriaServico()) ?></td>
                                    <td><a href="/dashboard/servico/form?id=<?= htmlspecialchars($cservico->getIdCategoriaServico()) ?>">Editar</a></td>
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
<div id="fullscreen-container" style="display: none;">
    <div class="contentBox" id="fullscreen-details">
        <div class="title-details">
            <h2 class="text-information">Detalhamento da Categoria de Serviço</h2>
            <a class="closeIcon" onclick="closeFullScreen()"><i class="fa-solid fa-xmark"></i></a>
        </div>
        <div class="container-details">
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-pen-to-square"></i>
                    <h2 class="text-details">Nome da Categoria de Serviço:</h2>
                </div>
                <h3 class="small-text" id="nome"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-comment" style="transform: scaleX(-1);"></i>
                    <h2 class="text-details">Descrição da Categoria de Serviço:</h2>
                </div>
                <h3 class="small-text" id="descricao"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-file-pen"></i>
                    <h2 class="text-details">Deseja editar a Categoria de Serviço?</h2>
                </div>
                <a class="btn-add" id="editar">Editar Categoria</a>
            </div>
        </div>
    </div>
</div>