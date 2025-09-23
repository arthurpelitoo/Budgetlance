<?php $cliente = $cliente ?? null; ?>

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
    <div class='cliente_div'>
        <div class="cliente_div_form">
            <a href="/dashboard/cliente" class="nav-button" aria-label="Anterior">
                «
            </a>

            <!-- formulario com metodo post que aponta para uma rota do rotas.php-->
            <form class='cliente_form' method="post" action="/dashboard/cliente/form/salvar">
                
                <?php if(!empty($cliente)): ?>
                <h1 class='cliente_title'>Atualize informações sobre seu Cliente</h1>
                <?php else: ?>
                <h1 class='cliente_title'>Insira informações sobre seu Cliente</h1>
                <?php endif ?>

                <input name="id" value="<?= $cliente ? htmlspecialchars($cliente->getIdCliente()) : '' ?>" type="hidden" />

                <label for="nome" class='label_form'>
                    Nome*:
                </label>
                <input class='input_form' id="nome" name="nome" value="<?= $cliente ? htmlspecialchars($cliente->getNomeCliente()) : '' ?>" type="text" maxlength="30" placeholder="Nome do Cliente"/>
                <small id="nomeErro" style="color: white; font-family: var(--font-default);"></small>
                <br>

                <label for="telefone" class='label_form'>
                    Telefone:
                </label>
                <input class='input_form' id="telefone" name="telefone" value="<?= $cliente ? htmlspecialchars($cliente->getTelefoneCliente()) : '' ?>" type="tel" maxlength="15" placeholder="Telefone do Cliente"/>
                <small id="telefoneErro" style="color: white; font-family: var(--font-default);"></small>
                <br>

                <label for="email" class='label_form'>
                    Email:
                </label>
                <input class='input_form' id="email" name="email" value="<?= $cliente ? htmlspecialchars($cliente->getEmailCliente()) : '' ?>" type="text" maxlength="64" placeholder="Email do Cliente"/>
                <small id="emailErro" style="color: white; font-family: var(--font-default);"></small>
                <br>

                <button type="submit" class="btn_form">Confirmar cliente</button>

            </form>
        </div>
    </div>
</main>