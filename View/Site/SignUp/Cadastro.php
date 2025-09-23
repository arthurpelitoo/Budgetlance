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
    <div class='cadastro_div'>
        <!-- formulario com metodo post que aponta para uma rota do rotas.php-->
        <form class='cadastro_form' method="post" action="/signUp/form/salvar">
            <h1 class='cadastro_title'>Faça seu Cadastro</h1>

            <label for="nome" class='label_form'>
                Nome:
            </label>
            <input class='input_form' id="nome" name="nome" value="" type="text" maxlength="20" placeholder="Insira algum nome"/>
            <small id="nomeErro" style="color: white; font-family: var(--font-default);"></small>
            <br>

            <label for="email" class='label_form'>
                Email:
            </label>
            <input class='input_form' id="email" name="email" value="" type="text" maxlength="64" placeholder="Insira seu email"/>
            <small id="emailErro" style="color: white; font-family: var(--font-default);"></small>
            <br>

            <label for="senha" class='label_form'>
                Senha:
            </label>
            <input class='input_form' id="senha" name="senha" value="" type="password" maxlength="20" placeholder="Insira alguma senha forte"/>
            <small id="senhaErro" style="color: white; font-family: var(--font-default);"></small>
            <br>

            <button type="submit" class="btn_form">Confirmar cadastro</button>

            <a class="link" href="/login">Já possui uma conta?</a>

        </form>
    </div>
</main>