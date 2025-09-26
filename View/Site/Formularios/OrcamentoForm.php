<?php $orcamento = $orcamento ?? null; ?>

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
    <div class='orcamento_div'>
        <div class="orcamento_div_form">
            <a href="/dashboard/orcamento" class="nav-button" aria-label="Anterior">
                «
            </a>

            <!-- formulario com metodo post que aponta para uma rota do rotas.php-->
            <form class='orcamento_form' method="post" action="/dashboard/orcamento/form/salvar" id="orcamento_form">
                

                <input name="id" value="<?= $orcamento ? htmlspecialchars($orcamento->getIdOrcamento()) : '' ?>" type="hidden" />

                <?php if(!empty($orcamento)): ?>
                <h1 class='orcamento_title'>Atualize informações sobre seu orçamento</h1>
                <?php else: ?>
                <h1 class='orcamento_title'>Insira informações sobre seu orçamento</h1>
                <?php endif ?>
                
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: 0%;"></div>
                </div>

                <!-- ETAPA 1: Informações do Cliente -->

                <div class="step active">
                    <h3 style="color: white; font-family: var(--font-default);">Etapa 1: Cliente e Serviço</h2>
                    <div class="form_field">
                        <label for="cliente" class='label_form'>
                            Cliente que receberá o serviço*:
                        </label>
                        <select class='select_form' name="cliente" id="cliente" >
                            <option value="">Selecione um cliente</option>
                            <?php foreach($clientes as $cliente): ?>
                                <option value="<?= htmlspecialchars($cliente['id']) ?>"
                                    <?= $orcamento && $orcamento->getIdCliente() === (int) $cliente['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cliente['nm_cliente']) ?>
                                </option>
                            <?php endforeach; ?>
                
                        </select>
                        <small class="error-message" id="clienteErro" style="color: white; font-family: var(--font-default);"></small>
                    </div>

                    <div class="form_field">
                        <label for="categoriaservico" class='label_form'>
                            Serviço que você fará*:
                        </label>
                        <select class='select_form' name="categoriaservico" id="categoriaservico" >
                            <option value="">Selecione um serviço</option>
                            <?php foreach($categorias as $categoria): ?>
                                <option value="<?= htmlspecialchars($categoria['id']) ?>"
                                    <?= $orcamento && $orcamento->getIdCategoriaServico() === (int) $categoria['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($categoria['nm_servico']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="error-message" id="categoriaservicoErro" style="color: white; font-family: var(--font-default);"></small>
                    </div>

                    <div class="button_group" id="firstStep">
                        <button type="button" class="btn btn-next" id="firstBtn">Próximo</button>
                    </div>

                </div>

                <!-- ETAPA 2: Detalhes do Orçamento -->
                <div class="step">
                    <h3 style="color: white; font-family: var(--font-default);">Etapa 2: Detalhes do Orçamento</h2>
                    <div class="form_field">
                        <label for="nome" class='label_form'>
                            Nome do Orçamento(resumo breve)*:
                        </label>
                        <input class='input_form' id="nome" name="nome" value="<?= $orcamento ? htmlspecialchars($orcamento->getNomeOrcamento()) : '' ?>" type="text" maxlength="50" placeholder="Nome do Orçamento"/>
                        <small class="error-message" id="nomeErro" style="color: white; font-family: var(--font-default);"></small>
                    </div>

                    <div class="form_field">
                        <label for="descricao" class='label_form'>
                            Descrição do Orçamento(Descrever com mais detalhes)*:
                        </label>
                        <textarea class='textarea_form' id="descricao" rows="10" name="descricao" type="text" maxlength="240" placeholder="Descricao do Orçamento"><?= $orcamento ? htmlspecialchars($orcamento->getDescricaoOrcamento()) : '' ?></textarea>
                        <small class="error-message" id="descricaoErro" style="color: white; font-family: var(--font-default);"></small>
                    </div>

                    <div class="button_group">
                        <button type="button" class="btn btn-prev">Anterior</button>
                        <button type="button" class="btn btn-next">Próximo</button>
                    </div>
                </div>

                <!-- ETAPA 3: Valor e Prazo -->
                <div class="step">
                    <h3 style="color: white; font-family: var(--font-default);">Etapa 3: Prazo e Valor</h2>
                    <div class="form_field">
                        <label for="valor" class="label_form">
                            Valor do Orçamento*:
                        </label>
                        <input class='input_form' id="valor" name="valor" value="<?= $orcamento ? htmlspecialchars($orcamento->getValorOrcamento()) : '' ?>" type="number" step="0.01" placeholder="Valor pelo serviço, ex: 450,00">
                        <small class="error-message" id="valorErro" style="color: white; font-family: var(--font-default);"></small>
                    </div>

                    <div class="form_field">
                        <label for="prazo" class="label_form">
                            Prazo do Orçamento*:
                        </label>
                        <input class='input_form' value="<?= $orcamento ? htmlspecialchars($orcamento->getPrazoFormatadoOrcamento()) : '' ?>" type="date" id="prazo" name="prazo" placeholder="Prazo de entrega">
                        <small class="error-message" id="prazoErro" style="color: white; font-family: var(--font-default);"></small>
                    </div>
                    
                    <div class="form_field">
                        <label for="status" class="label_form">
                            Status do Orçamento*:
                        </label>
                        <select class='input_form' name="status" id="status" name="status">
                            <option value="pendente" <?= $orcamento && $orcamento->getStatusOrcamento() === "pendente" ? 'selected' : '' ?> >Pendente</option>
                            <option value="enviado" <?= $orcamento && $orcamento->getStatusOrcamento() === "enviado" ? 'selected' : '' ?> >Enviado</option>
                            <option value="aprovado" <?= $orcamento && $orcamento->getStatusOrcamento() === "aprovado" ? 'selected' : '' ?> >Aprovado</option>
                            <option value="concluido" <?= $orcamento && $orcamento->getStatusOrcamento() === "concluido" ? 'selected' : '' ?> >Concluído</option>
                            <option value="cancelado" <?= $orcamento && $orcamento->getStatusOrcamento() === "cancelado" ? 'selected' : '' ?> >Cancelado</option>
                            <option value="recusado" <?= $orcamento && $orcamento->getStatusOrcamento() === "recusado" ? 'selected' : '' ?> >Recusado</option>
                            <option value="expirado" <?= $orcamento && $orcamento->getStatusOrcamento() === "expirado" ? 'selected' : '' ?> >Expirado</option>
                        </select>
                        <small class="error-message" id="statusErro" style="color: white; font-family: var(--font-default);"></small>
                    </div>

                    <div class="button_group">
                        <button type="button" class="btn btn-prev">Anterior</button>
                        <button type="submit" class="btn btn_form">Enviar Orçamento</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</main>