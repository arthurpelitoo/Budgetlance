<?php

namespace Budgetlance\Controller\Site;
/**
 * namespace serve pra definir caminhos para autoload de classes e para nao se confundir com metódos publicos do php. (o Composer precisa disso!)
 */

use Budgetlance\Controller\Categoria_Servico\ControllerCServico;
use Budgetlance\Controller\Cliente\ControllerCliente;
use Budgetlance\Controller\Controller;
use Budgetlance\Controller\Orcamento\ControllerOrcamento;
use Budgetlance\Dao\Site\Categoria_Servico\DaoCServico;
use Budgetlance\Dao\Site\Cliente\DaoCliente;

final class ControllerSite extends Controller
{
    public static function erro404()
    {
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Erro/Erro404";
        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Conheça a Budgetlance!",
            "pageCss" => [
                CSS_SITE_URL . "Erro/Erro404.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "Erro/erro404.png"
            ],
            "pageJs" => [
                JS_SITE_URL . "Erro/Erro404.js"
            ],
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);

    }

    public static function home()
    {
        
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Home/PaginaInicial";
        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Conheça a Budgetlance!",
            "pageCss" => [
                CSS_SITE_URL . "Home/PaginaInicial.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "Home/banner_freelancer_preocupado.jpg"
            ],
            "pageJs" => [
                JS_SITE_URL . "Home/PaginaInicial.js"
            ],
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);

    }

    public static function signUp()
    {
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "SignUp/Cadastro";
        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Cadastre-se na Budgetlance!",
            "pageCss" => [
                CSS_SITE_URL . "SignUp/Cadastro.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "SignUp/SignUpBackground.jpg"
            ],
            "pageJs" => [
                JS_SITE_URL . "SignUp/Cadastro.js"
            ],
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);
    }

    public static function login()
    {
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Login/Login";
        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Faça seu login na Budgetlance!",
            "pageCss" => [
                CSS_SITE_URL . "Login/Login.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "Login/LoginBackground.jpg"
            ],
            "pageJs" => [
                JS_SITE_URL . "Login/Login.js"
            ],
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);
    }

    public static function mainDashboard()
    {
        //pergunta se o cara está logado, se não estiver, joga pra login.
        parent::isProtected();

        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Dashboard/MainDashboard";
        $controllerOrcamento = new ControllerOrcamento();

        // pega o id do usuário logado
        $usuario = $_SESSION['logado'];
        $idUsuario = $usuario->getIdUsuario() ?? null;

        $filtro = $_GET['filtro'] ?? null;
        $pesquisa = !empty($_GET['pesquisa']) ? trim($_GET['pesquisa']) : null;
        $operador = 'LIKE'; // Operador padrão para pesquisa de texto

        if(isset($filtro)){
            
            // Se o filtro for valor, usa o operador do GET, senão, usa LIKE.
            if ($filtro === 'valor' || $filtro === 'prazo' && isset($operador)) {
                $operador = $_GET['operador'];
            }
            $orcamentos = $controllerOrcamento->listarOrcamentos($idUsuario, $filtro, $pesquisa, $operador);
        }

        $orcamentos = $controllerOrcamento->listarOrcamentos($idUsuario, $filtro, $pesquisa, $operador);
        $pesquisou = $filtro && $pesquisa ? true : null;

        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Dashboard de gerenciamento geral",
            "pageCss" => [
                CSS_SITE_URL . "Dashboard/MainDashboard.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "Dashboard/MainDashboardBackground.jpg"
            ],
            "pageJs" => [
                JS_SITE_URL . "Dashboard/MainDashboard.js"
            ],
            "orcamentos" => $orcamentos,
            "pesquisou" => $pesquisou,
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);
    }

    public static function clienteDashboard()
    {
        parent::isProtected();
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Dashboard/ClienteDashboard";
        $controllerCliente = new ControllerCliente();

        // pega o id do usuário logado
        $usuario = $_SESSION['logado'];
        $idUsuario = $usuario->getIdUsuario() ?? null;

        $filtro = $_GET['filtro'] ?? null;
        $pesquisa = !empty($_GET['pesquisa']) ? trim($_GET['pesquisa']) : null;

        $clientes = $controllerCliente->listarClientes($idUsuario, $filtro, $pesquisa);

        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Dashboard de Cliente",
            "pageCss" => [
                CSS_SITE_URL . "Dashboard/ClienteDashboard.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "Dashboard/ClienteDashboardBackground.jpg"
            ],
            "pageJs" => [
                JS_SITE_URL . "Dashboard/ClienteDashboard.js"
            ],
            "clientes" => $clientes,
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);
    }

    public static function clienteForm()
    {
        parent::isProtected();
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Formularios/ClienteForm";

        //(pra funcao UPDATE).
        if(isset($_GET['id']))
        {
            $controllerCliente = new ControllerCliente();
            // vai retornar as informações pro formulario por meio do ID que é recebido via URL. (pra funcao UPDATE).
            $cliente = $controllerCliente->pegarPeloId((int) $_GET['id']); // O (int) evita sqlInjection, sendo um type cast explícito. Ele converte o valor recebido (nesse caso, uma string que veio da URL) para o tipo inteiro.
            
            /**
             * se ele ver que não procede, entrega erro
             */
            if (!$cliente) {
                $_SESSION['errorTitle'] = "Erro no Cliente!";
                $_SESSION['error'] = "Nenhum cliente selecionado.";
                header("Location: /dashboard/cliente");
                exit;
            }
        }else{
            $cliente = null;
        }

        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            
            "title" => "Formulario de Cliente",
            "pageCss" => [
                CSS_SITE_URL . "Formularios/ClienteForm.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "Formularios/ClienteFormBackground.jpg"
            ],
            "pageJs" => [
                JS_SITE_URL . "Formularios/ClienteForm.js"
            ],

            "cliente" => $cliente,
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);
    }

    public static function servicoDashboard()
    {
        parent::isProtected();
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Dashboard/CServicoDashboard";

        $controllerCServico = new ControllerCServico();

        // pega o id do usuário logado
        $usuario = $_SESSION['logado'];
        $idUsuario = $usuario->getIdUsuario() ?? null;

        $filtro = $_GET['filtro'] ?? null;
        $pesquisa = !empty($_GET['pesquisa']) ? trim($_GET['pesquisa']) : null;

        $cservicos = $controllerCServico->listarCategoriaServicos($idUsuario, $filtro, $pesquisa);

        

        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Dashboard de Serviço",
            "pageCss" => [
                CSS_SITE_URL . "Dashboard/CServicoDashboard.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "Dashboard/CServicoDashboardBackground.jpg"
            ],
            "pageJs" => [
                JS_SITE_URL . "Dashboard/CServicoDashboard.js"
            ],
            "cservicos" => $cservicos,
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);
    }

    public static function servicoForm()
    {
        parent::isProtected();
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Formularios/CServicoForm";

        //(pra funcao UPDATE).
        if(isset($_GET['id']))
        {
            $controllerCServico = new ControllerCServico();
            
            // vai retornar as informações pro formulario por meio do ID que é recebido via URL. (pra funcao UPDATE).
            $cservico = $controllerCServico->pegarPeloId((int) $_GET['id']); // O (int) evita sqlInjection, sendo um type cast explícito. Ele converte o valor recebido (nesse caso, uma string que veio da URL) para o tipo inteiro.
            
            /**
             * se ele ver que não procede, entrega erro
             */
            if (!$cservico) {
                $_SESSION['errorTitle'] = "Erro na Categoria de Serviço!";
                $_SESSION['error'] = "Nenhum serviço selecionado.";
                header("Location: /dashboard/servico");
                exit;
            }
        }else{
            $cservico = null;
        }

        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            
            "title" => "Formulario de Serviço",
            "pageCss" => [
                CSS_SITE_URL . "Formularios/CServicoForm.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "Formularios/CServicoFormBackground.jpg"
            ],
            "pageJs" => [
                JS_SITE_URL . "Formularios/CServicoForm.js"
            ],

            "cservico" => $cservico,
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);
    }

    public static function orcamentoDashboard()
    {
        // verifica se o usuario ja fez cadastro das outras tabelas.
        parent::isCompleted();
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Dashboard/OrcamentoDashboard";
        
        $controllerOrcamento = new ControllerOrcamento();

        // pega o id do usuário logado
        $usuario = $_SESSION['logado'];
        $idUsuario = $usuario->getIdUsuario() ?? null;

        $filtro = $_GET['filtro'] ?? null;
        $pesquisa = !empty($_GET['pesquisa']) ? trim($_GET['pesquisa']) : null;
        $operador = 'LIKE'; // Operador padrão para pesquisa de texto

        if(isset($filtro)){
            
            // Se o filtro for valor, usa o operador do GET, senão, usa LIKE.
            if ($filtro === 'valor' || $filtro === 'prazo' && isset($operador)) {
                $operador = $_GET['operador'];
            }
            $orcamentos = $controllerOrcamento->listarOrcamentos($idUsuario, $filtro, $pesquisa, $operador);
        }

        $orcamentos = $controllerOrcamento->listarOrcamentos($idUsuario, $filtro, $pesquisa, $operador);
        $pesquisou = $orcamentos ? true : null;

        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Dashboard de Orçamento",
            "pageCss" => [
                CSS_SITE_URL . "Dashboard/OrcamentoDashboard.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "Dashboard/OrcamentoDashboardBackground.jpg"
            ],
            "pageJs" => [
                JS_SITE_URL . "Dashboard/OrcamentoDashboard.js"
            ],
            "orcamentos" => $orcamentos,
            "pesquisou" => $pesquisou,
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);
    }

    public static function orcamentoForm()
    {
        parent::isCompleted();
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Formularios/OrcamentoForm";

        $controllerOrcamento = new ControllerOrcamento();
        $clientes = $controllerOrcamento->pegarPeloCliente();
        $categorias = $controllerOrcamento->pegarPelaCategoriaServico();
        
        //(pra funcao UPDATE).
        if(isset($_GET['id']))
        {
            // vai retornar as informações pro formulario por meio do ID que é recebido via URL. (pra funcao UPDATE).
            $orcamento = $controllerOrcamento->pegarPeloId((int) $_GET['id']); // O (int) evita sqlInjection, sendo um type cast explícito. Ele converte o valor recebido (nesse caso, uma string que veio da URL) para o tipo inteiro.
            
            /**
             * se ele ver que não procede, entrega erro
             */
            if (!$orcamento) {
                $_SESSION['errorTitle'] = "Erro no Orçamento!";
                $_SESSION['error'] = "Você não tem permissão para editar este orçamento.";
                header("Location: /dashboard/orcamento");
                exit;
            }
        }else{
            $orcamento = null;
        }

        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Formulario de Orçamento",
            "pageCss" => [
                CSS_SITE_URL . "Formularios/OrcamentoForm.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "Formularios/OrcamentoFormBackground.jpg"
            ],
            "pageJs" => [
                JS_SITE_URL . "Formularios/OrcamentoForm.js"
            ],
            "clientes" => $clientes,
            "categorias" => $categorias,
            "orcamento" => $orcamento,
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);
    }
}