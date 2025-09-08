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
    <section class="dashboard-section container">
        <div class="grid-container contentBox">
            <header class="grid-header">
                <h2 class="header-title-column1"></h2>
                <a href="" class="header-link-column2"></a>
            </header>
            <section class="grid-section">
                <div class="section-content-column1">
                    <h2 class="item-title"></h2>
                    <h3 class="item-deadline"></h3>
                </div>
                <div class="section-content-column2">
                    <h4 class="item-price"></h4>
                </div>
            </section>
        </div>
        <div class="contentBox">
            <nav>
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </nav>
        </div>
        <div class="contentBox">
            <h2>Dashboard de Orçamento de Serviços</h2>
            <table>
                <!-- < if(count($model->rows) == 0): ?> -->
                    <tr>
                        <td colspan="10">Nenhum registro foi encontrado.</td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <p>Tente adicionar algum serviço que você fornece e algum cliente antes para montar um orçamento.</p>
                        </td>
                    </tr>
                <!-- < endif ?> -->
                <!-- < if(count($model->rows) > 0): ?> -->
                    <tr>
                        <th></th>
                        <th>Serviço Nº</th>
                        <th>Cliente</th>
                        <th>Categ. Serviço</th>
                        <th>Nome Serviço</th>
                        <th>Descricao Serviço</th>
                        <th>Valor pelo Serviço</th>
                        <th>Prazo</th>
                        <th>Status atual</th>
                        <th></th>
                    </tr>
                <!-- < endif?> -->
                    <tr>
                        <td><a href="">X</a></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><a href="">Editar</a></td>
                    </tr>
            </table>
        </div>
    </section>
</main>