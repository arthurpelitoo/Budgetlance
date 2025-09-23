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
    <section class="pageContainer">
        <section class="process-section container">
            <section class="grid-container contentBox">
                <header class="grid-header">
                    <h2 class="header-title-column1">Prazos a cumprir:</h2>
                    <a href="" class="header-link-column2">Ver os serviços a expirar detalhadamente</a>
                </header>
                <hr>
                <section class="grid-section">
                    <?php  
                        // casos possiveis,
                        $validStatuses = ['pendente','enviado','aprovado'];
                        // se $orcamentos for array, ele filtra os arrays dentro dos casos permitidos e retorna dentro da variavel $orcamentosValidos, se não for entrega um array vazio pro php nao chorar.
                        $orcamentosValidos = is_array($orcamentos) ? array_filter($orcamentos, function($orc) use ($validStatuses) {
                            return in_array($orc->getStatusOrcamento(), $validStatuses);
                        }) : [];

                        // Ordena os orçamentos pelo prazo (do mais próximo para o mais distante)
                        usort($orcamentosValidos, function($a, $b) {
                            $prazoA = $a->getPrazoOrcamento(); // supondo que retorna DateTime
                            $prazoB = $b->getPrazoOrcamento();

                            //o operador spaceship (<=>) faz a verificação automatica de ordem prioritaria,
                            //ou seja, retorna automaticamente -1, 0 ou 1. 
                            /**
                             * Quando se usa usort(), o PHP espera que a função de comparação retorne um número inteiro:
                             * -1 → significa que $a deve vir antes de $b na lista.
                             * 0 → significa que $a e $b são considerados iguais para a ordenação.
                             * 1 → significa que $a deve vir depois de $b.
                             */
                            return $prazoA <=> $prazoB;
                        });
                    ?>
                    <?php if(!empty($orcamentosValidos)): ?>
                        <?php foreach($orcamentosValidos as $orcamento): ?>
                        <div class="card">
                            <div class="section-content-column1">
                                <h2 class="item-title"><?= htmlspecialchars($orcamento->getNmCliente()) ?></h2>
                                <h3 class="item-deadline">Prazo: <?= htmlspecialchars($orcamento->getPrazoFormatadoOrcamento('d/m/Y'))?></h3>
                            </div>
                            <div class="section-content-column2">
                                <h4 class="item-price">Preço: R$<?= htmlspecialchars($orcamento->getValorFormatadoOrcamento()) ?></h4>
                            </div>
                        </div>
                        <?php endforeach ?>
                    <?php else: ?> 
                        <div class="card">
                            <div class="section-content-column1">
                                <h2 class="item-title">No momento, não há prazos ou serviços a cumprir.</h2>
                            </div>
                            <div class="section-content-column2">
                                <a style="display: block;" class="btn-add" href="/dashboard/orcamento/form">
                                    Cadastrar Orçamento
                                </a>
                            </div>
                        </div>
                    <?php endif ?>
                </section>
            </section>
            <section class="control-panel-section">
                <nav class="control-panel contentBox">
                    <h2 class="control-panel-title">Painel de Controle</h2>
                    <ul>
                        <li>
                            <a class="control-panel-btn" href="/dashboard/cliente">Adicionar e gerenciar clientes</a>
                        </li>
                        <li>
                            <a class="control-panel-btn" href="/dashboard/servico">Adicionar e gerenciar categorias de serviços</a>
                        </li>
                        <li>
                            <a class="control-panel-btn" href="/dashboard/orcamento">Criar e gerenciar orçamentos</a>
                        </li>
                    </ul>
                </nav>
            </section>
        </section>
        <section class="dashboard-section">
            <section class="dashboard-container contentBox">
                <div class="dashboard">
                    <h2 class="dashboard-title">Dashboard de Orçamento</h2>
                    <?php if(!empty($orcamentos)): ?>
                    <table class="dashboard-budget-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Cliente</th>
                                    <th>Serviço</th>
                                    <th>Nome</th>
                                    <th>Valor</th>
                                    <th>Prazo</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orcamentos as $orcamento): ?>
                                <tr>
                                    <td><a class="btn_delete" onclick="confirmarExclusao(<?= $orcamento->getIdOrcamento() ?>)">X</a></td>
                                    <td><?= htmlspecialchars($orcamento->getNmCliente()) ?></td>
                                    <td><?= htmlspecialchars($orcamento->getNmCategoriaServico()) ?></td>
                                    <td><?= htmlspecialchars($orcamento->getNomeOrcamento()) ?></td>
                                    <td>R$<?= htmlspecialchars($orcamento->getValorFormatadoOrcamento()) ?></td>
                                    <td><?= htmlspecialchars($orcamento->getPrazoFormatadoOrcamento('d/m/Y'))?></td>
                                    <td><?= htmlspecialchars($orcamento->getStatusOrcamento())?></td>
                                    <td><a href="/dashboard/orcamento/form?id=<?= $orcamento->getIdOrcamento() ?>">Editar</a></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                    </table>
                    <h3 class="dashboard-title">Deseja cadastrar mais orçamentos?</h3>
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