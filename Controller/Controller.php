<?php

/**
 * Separei render em dois, um para o caminho que leva ao site que só contas tipo_usuario admin vê.
 * e outro que leva ao site onde apenas o Usuario comum vê.
 */

namespace Budgetlance\Controller;

abstract class Controller
{
    protected static function renderSiteView($view, $viewData = [])
    {
        //conteudo do arquivo view a ser exportado dentro dessa variavel pro layout (que tem junto o header e o footer):
        $contentView = VIEW_SITE_PATH . $view . ".php";

        /**
         * o extract funciona como um rodizio
         * ele entrega varios pratos com dados
         * e cada um que precisa de um dado ou variavel especifica nesse prato, simplesmente vai la e pega.
         */
        extract($viewData);

        /**
         * puxa o layout a ser montado pra index.php e fim.
         */
        require VIEW_TEMPLATES_PATH . "layout.php";
    }

    protected static function isProtected()
    {
        if(!isset($_SESSION['usuario_id'])){
            $_SESSION['errorTitle'] = "Você não está logado.";
            $_SESSION['error'] = "Faça login para poder acessar esses recursos.";
            header("Location: /login");
        }
    }
}