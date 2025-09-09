<main>
    <?php if(!isset($_SESSION['usuario_nome'])): ?>
        <div id="modal-container" class="modal-container">
            <div class="modal">
                <div class="modalContainerTitle">
                    <h3 class="modalTitle">
                        Faça Login ou cadastre-se
                    </h3>
                </div>
                <div class="modalContainerMessage">
                    <p class="modalMessage">
                        Faça Login ou cadastre-se para acessar o Dashboard Gerenciador.
                    </p>
                </div>
                <div class="modalDualButton">
                    <button onclick="enviarParaOLogin()">
                        Fazer Login
                    </button>
                    <button onclick="enviarParaOSignUp()">
                        Se Cadastrar
                    </button>
                </div>
            </div>
        </div>
        <div id="modal-overlay" class="modal-overlay"></div>
    <?php endif; ?>
    <section class="background-image">
        <section class="process-section container">
            <section class="grid-container contentBox">
                <header class="grid-header">
                    <h2 class="header-title-column1">Prazos a cumprir:</h2>
                    <a href="" class="header-link-column2">Ver os serviços a expirar detalhadamente</a>
                </header>
                <hr>
                <section class="grid-section">
                    <div class="card">
                        <div class="section-content-column1">
                            <h2 class="item-title">Cliente 28</h2>
                            <h3 class="item-deadline">Prazo: 12/05/2026</h3>
                        </div>
                        <div class="section-content-column2">
                            <h4 class="item-price">Preço: R$ 1199,99</h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="section-content-column1">
                            <h2 class="item-title">Cliente 28</h2>
                            <h3 class="item-deadline">Prazo: 12/05/2026</h3>
                        </div>
                        <div class="section-content-column2">
                            <h4 class="item-price">Preço: R$ 1199,99</h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="section-content-column1">
                            <h2 class="item-title">Cliente 28</h2>
                            <h3 class="item-deadline">Prazo: 12/05/2026</h3>
                        </div>
                        <div class="section-content-column2">
                            <h4 class="item-price">Preço: R$ 1199,99</h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="section-content-column1">
                            <h2 class="item-title">Cliente 28</h2>
                            <h3 class="item-deadline">Prazo: 12/05/2026</h3>
                        </div>
                        <div class="section-content-column2">
                            <h4 class="item-price">Preço: R$ 1199,99</h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="section-content-column1">
                            <h2 class="item-title">Cliente 28</h2>
                            <h3 class="item-deadline">Prazo: 12/05/2026</h3>
                        </div>
                        <div class="section-content-column2">
                            <h4 class="item-price">Preço: R$ 1199,99</h4>
                        </div>
                    </div>
                </section>
            </section>
            <section class="control-panel-section">
                <nav class="control-panel contentBox">
                    <h2 class="control-panel-title">Painel de Controle</h2>
                    <ul>
                        <li>
                            <a class="control-panel-btn" href="">Adicionar e gerenciar clientes</a>
                        </li>
                        <li>
                            <a class="control-panel-btn" href="">Adicionar e gerenciar categorias de serviços</a>
                        </li>
                        <li>
                            <a class="control-panel-btn" href="">Criar e gerenciar orçamentos</a>
                        </li>
                    </ul>
                </nav>
            </section>
        </section>
        <section class="dashboard-section">
            <section class="dashboard-container contentBox">
                <div class="dashboard">
                    <h2 class="dashboard-title">Dashboard de Orçamento</h2>
                    <table class="dashboard-budget-table">
                        <!-- < if(count($model->rows) > 0): ?> -->
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Serv. Nº</th>
                                    <th>Cliente</th>
                                    <th>Categ. Serviço</th>
                                    <th>Nome Serviço</th>
                                    <th>Descricao Serviço</th>
                                    <th>Valor pelo Serviço</th>
                                    <th>Prazo</th>
                                    <th>Status atual</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="">X</a></td>
                                    <td>adsdadsadsa</td>
                                    <td>sadasdad</td>
                                    <td>aasdsad</td>
                                    <td>adsasdad</td>
                                    <td>adsada</td>
                                    <td>adsadada</td>
                                    <td>daasdad</td>
                                    <td>adsadsa</td>
                                    <td><a href="">Editar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="">X</a></td>
                                    <td>adsdadsadsa</td>
                                    <td>sadasdad</td>
                                    <td>aasdsad</td>
                                    <td>adsasdad</td>
                                    <td>adsada</td>
                                    <td>adsadada</td>
                                    <td>daasdad</td>
                                    <td>adsadsa</td>
                                    <td><a href="">Editar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="">X</a></td>
                                    <td>adsdadsadsa</td>
                                    <td>sadasdad</td>
                                    <td>aasdsad</td>
                                    <td>adsasdad</td>
                                    <td>adsada</td>
                                    <td>adsadada</td>
                                    <td>daasdad</td>
                                    <td>adsadsa</td>
                                    <td><a href="">Editar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="">X</a></td>
                                    <td>adsdadsadsa</td>
                                    <td>sadasdad</td>
                                    <td>aasdsad</td>
                                    <td>adsasdad</td>
                                    <td>adsada</td>
                                    <td>adsadada</td>
                                    <td>daasdad</td>
                                    <td>adsadsa</td>
                                    <td><a href="">Editar</a></td>
                                </tr>
                            </tbody>
                            <!-- < endif?> -->
                            <!-- < if(count($model->rows) == 0): ?> -->
                            <!-- <tr>
                                <td colspan="10">Nenhum registro foi encontrado.</td>
                            </tr>
                            <tr>
                                <td colspan="10">
                                    <p>Tente adicionar algum serviço que você fornece e algum cliente antes para montar um orçamento.</p>
                                </td>
                            </tr> -->
                        <!-- < endif ?> -->
                    </table>
                </div>
            </section>
        </section>
    </section>
</main>