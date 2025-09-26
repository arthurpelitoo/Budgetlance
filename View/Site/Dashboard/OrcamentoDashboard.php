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
                <p class="modalMessage">Tem certeza que deseja excluir este orçamento?</p>
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
                    <h2 class="dashboard-title">Dashboard de Orçamento</h2>

                    <h3 class="dashboard-title">Crie um orçamento, liste-os, edite-os ou os exclua.</h3>

                    <?php if(!empty($orcamentos)): ?>

                    <form class="search-form" method="get" action="/dashboard/orcamento">
                        <h4 class="text-form">Pesquise usando filtros para listagens precisas!</h4>
                        <div class="search-form-div">
                            <div class="search-group">
                                <input class="input_form" type="text" name="pesquisa" placeholder="Pesquisar..." >
                                <select class="select_form" name="filtro" id="filtro-select">
                                    <option value="">Filtrar por:</option>
                                    <option value="cliente">Nome do Cliente</option>
                                    <option value="servico">Nome do Serviço</option>
                                    <option value="nome">Nome do Orçamento</option>
                                    <option value="descricao">Descrição do Orçamento</option>
                                    <option value="valor">Valor do Orçamento</option>
                                    <option value="prazo">Prazo</option>
                                    <option value="status">Status</option>
                                </select>
                                <!-- Este select será exibido apenas para o filtro "Valor" -->
                                <select class="select_form" hidden name="operador" id="valor-operador">
                                    <option id="operador-igual" value="=">Igual a</option>
                                    <option id="operador-maiorque" value=">">Maior que</option>
                                    <option id="operador-menorque" value="<">Menor que</option>
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
                                    <th>Serviço</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Prazo</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orcamentos as $orcamento): ?>
                                    <tr
                                        onclick="openFullScreen(this)"
                                        data-key="<?= htmlspecialchars($orcamento->getIdOrcamento()) ?>"
                                        data-cliente="<?= htmlspecialchars($orcamento->getNmCliente()) ?>"
                                        data-servico="<?= htmlspecialchars($orcamento->getNmCategoriaServico()) ?>"
                                        data-nome="<?= htmlspecialchars($orcamento->getNomeOrcamento()) ?>"
                                        data-descricao="<?= htmlspecialchars($orcamento->getDescricaoOrcamento()) ?>"
                                        data-valor="R$ <?= htmlspecialchars($orcamento->getValorFormatadoOrcamento()) ?>"
                                        data-prazo="<?= htmlspecialchars($orcamento->getPrazoFormatadoOrcamento('d/m/Y')) ?>"
                                        data-status="<?= htmlspecialchars($orcamento->getStatusOrcamento()) ?>"
                                    >
                                        <td><a class="btn_delete" onclick="confirmarExclusao(<?= htmlspecialchars($orcamento->getIdOrcamento()) ?>)"><i class="fa-solid fa-xmark"></i></a></td>
                                        <td><?= htmlspecialchars($orcamento->getNmCliente()) ?></td>
                                        <td><?= htmlspecialchars($orcamento->getNmCategoriaServico()) ?></td>
                                        <td><?= htmlspecialchars($orcamento->getNomeOrcamento()) ?></td>
                                        <td><?= htmlspecialchars($orcamento->getDescricaoOrcamento()) ?></td>
                                        <td>R$<?= htmlspecialchars($orcamento->getValorFormatadoOrcamento()) ?></td>
                                        <td><?= htmlspecialchars($orcamento->getPrazoFormatadoOrcamento('d/m/Y'))?></td>
                                        <td><?= htmlspecialchars($orcamento->getStatusOrcamento())?></td>
                                        <td><a href="/dashboard/orcamento/form?id=<?= htmlspecialchars($orcamento->getIdOrcamento()) ?>">Editar</a></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                    </table>
                    <h3 class="dashboard-title">Deseja cadastrar mais orçamentos?</h3>
                    <a class="btn-add" href="/dashboard/orcamento/form">
                        Cadastrar Orçamento
                    </a>
                    <?php elseif(empty($orcamentos) && $pesquisou): ?> 

                            <form class="search-form" method="get" action="/dashboard/orcamento">
                                <h4 class="text-form">Pesquise usando filtros para listagens precisas!</h4>
                                <div class="search-form-div">
                                    <div class="search-group">
                                        <input class="input_form" type="text" name="pesquisa" placeholder="Pesquisar..." >
                                        <select class="select_form" name="filtro" id="filtro-select">
                                            <option value="">Filtrar por:</option>
                                            <option value="cliente">Nome do Cliente</option>
                                            <option value="servico">Nome do Serviço</option>
                                            <option value="nome">Nome do Orçamento</option>
                                            <option value="descricao">Descrição do Orçamento</option>
                                            <option value="valor">Valor do Orçamento</option>
                                            <option value="prazo">Prazo</option>
                                            <option value="status">Status</option>
                                        </select>
                                        <!-- Este select será exibido apenas para o filtro "Valor" -->
                                        <select class="select_form" hidden name="operador" id="valor-operador">
                                            <option id="operador-igual" value="=">Igual a</option>
                                            <option id="operador-maiorque" value=">">Maior que</option>
                                            <option id="operador-menorque" value="<">Menor que</option>
                                        </select>
                                        <button class="btn_form" type="submit">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <h3 class="dashboard-title">Nenhum registro foi encontrado na pesquisa.</h3>

                            <a class="btn-add" href="/dashboard/orcamento/form">
                                Cadastrar Orçamento
                            </a>
                    <?php else: ?>
                        <h3 class="dashboard-title">Nenhum registro foi encontrado.</h3>
                        <a class="btn-add" href="/dashboard/orcamento/form">
                            Cadastrar Orçamento
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
            <h2 class="text-information">Detalhamento do orçamento</h2>
            <a class="closeIcon" onclick="closeFullScreen()"><i class="fa-solid fa-xmark"></i></a>
        </div>
        <div class="container-details">
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-user"></i>
                    <h2 class="text-details">Cliente:</h2>
                </div>
                <h3 class="small-text" id="cliente"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-clipboard"></i>
                    <h2 class="text-details">Serviço a fazer:</h2>
                </div>
                <h3 class="small-text" id="servico"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-pen-to-square"></i>
                    <h2 class="text-details">Nome do orçamento:</h2>
                </div>
                <h3 class="small-text" id="nome"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-comment" style="transform: scaleX(-1);"></i>
                    <h2 class="text-details">Descrição do orçamento:</h2>
                </div>
                <h3 class="small-text" id="descricao"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-dollar-sign"></i>
                    <h2 class="text-details">Valor do orçamento:</h2>
                </div>
                <h3 class="small-text" id="valor"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-calendar"></i>
                    <h2 class="text-details">Prazo do orçamento:</h2>
                </div>
                <h3 class="small-text" id="prazo"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-diagram-project"></i>
                    <h2 class="text-details">Status do orçamento:</h2>
                </div>
                <h3 class="small-text" id="status"></h3>
            </div>
            <div class="main-information">
                <div class="content-group">
                    <i class="icon fa-solid fa-file-pen"></i>
                    <h2 class="text-details">Deseja editar o orçamento?</h2>
                </div>
                <a class="btn-add" id="editar">Editar orçamento</a>
            </div>
        </div>
    </div>
</div>