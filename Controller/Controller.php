<?php



namespace Budgetlance\Controller;

use Budgetlance\Dao\Site\Categoria_Servico\DaoCServico;
use Budgetlance\Dao\Site\Cliente\DaoCliente;

abstract class Controller
{
    final protected static function renderSiteView($view, $viewData = [])
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

    final protected static function isProtected()
    {
        if(!isset($_SESSION['logado'])){
            $_SESSION['errorTitle'] = "Você não está logado.";
            $_SESSION['error'] = "Faça login para poder acessar esses recursos.";
            header("Location: /login");
        }
    }

    final protected static function isCompleted()
    {
        self::isProtected();

        $daoCliente = new DaoCliente();
        $daoCatServico = new DaoCServico();

        // pega o id do usuário logado
        $usuario = $_SESSION['logado'];
        $idUsuario = $usuario->getIdUsuario() ?? null;

        $resCliente = $daoCliente->usuarioPossuiCadastro($idUsuario);
        $resCatServico = $daoCatServico->usuarioPossuiCadastro($idUsuario);

        if(!$resCliente || !$resCatServico){
            $_SESSION['errorTitle'] = "Você não ainda não está apto";
            $_SESSION['error'] = "Cadastre pelo menos um cliente e uma categoria de serviço antes de acessar orçamento.";
            header("Location: /dashboard");
            exit;
        }

    }

}