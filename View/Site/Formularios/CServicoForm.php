<?php $servico = $servico ?? null; ?>

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
    <div class='servico_div'>
        <div class="servico_div_form">
            <a href="/dashboard/servico" class="nav-button" aria-label="Anterior">
                «
            </a>
            <!-- formulario com metodo post que aponta para uma rota do rotas.php-->
            <form class='servico_form' method="post" action="/dashboard/servico/form/salvar">

                <?php if(!empty($cservico)): ?>
                <h1 class='servico_title'>Atualize informações sobre seu serviço</h1>
                <?php else: ?>
                <h1 class='servico_title'>Insira informações sobre seu serviço</h1>
                <?php endif ?>

                <input name="id" value="<?= $cservico ? htmlspecialchars($cservico->getIdCategoriaServico()) : '' ?>" type="hidden" />

                <label for="nome" class='label_form'>
                    Nome da Categoria de Serviço*:
                </label>
                <input class='input_form' id="nome" name="nome" value="<?= $cservico ? htmlspecialchars($cservico->getNomeCategoriaServico()) : '' ?>" type="text" maxlength="30" placeholder="Nome da Categoria de Serviço"/>
                <small id="nomeErro" style="color: white; font-family: var(--font-default);"></small>
                <br>

                <label for="descricao" class='label_form'>
                    Descrição do Serviço:
                </label>
                <textarea class='textarea_form' id="descricao" rows="10" name="descricao" value="<?= $cservico ? htmlspecialchars($cservico->getDescricaoCategoriaServico()) : '' ?>" type="text" maxlength="240" placeholder="Descricao do Serviço"></textarea>
                <small id="descricaoErro" style="color: white; font-family: var(--font-default);"></small>
                <br>

                <button type="submit" class="btn_form">Confirmar servico</button>

            </form>
        </div>
    </div>
</main>