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
    <div class='login_div'>
        <!-- formulario com metodo post que aponta para uma rota do rotas.php-->
        <form class='login_form' method="post" action="/login/form/verificar">
            <h1 class='login_title'>Faça seu Login</h1>

            <label for="email" class='label_form'>
                Email:
            </label>
            <input class='input_form' id="email" name="email" value="" type="text" maxlength="64" placeholder="Coloque seu email"/>
            <br>

            <label for="senha" class='label_form'>
                Senha:
            </label>
            <input class='input_form' id="senha" name="senha" value="" type="password" maxlength="20" placeholder="Coloque sua senha"/>
            <br>

            <button type="submit" class="btn_form">Fazer login</button>

            <a class="link" href="/signUp">Deseja criar conta?</a>

        </form>
    </div>
</main>