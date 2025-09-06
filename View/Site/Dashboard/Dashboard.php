<main>
    <h1>Palmeiras não é time.</h1>
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
                <div class="modalButton">
                    <button onclick="fecharModal()">
                        Voltar para o login.
                    </button>
                    <button onclick="">
                        Voltar para o cadastro.
                    </button>
                </div>
            </div>
        </div>
        <div id="modal-overlay" class="modal-overlay"></div>
    <?php endif; ?>
</main>