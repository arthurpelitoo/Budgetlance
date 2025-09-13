<?php

namespace Budgetlance\Controller\Site;
/**
 * namespace serve pra definir caminhos para autoload de classes e para nao se confundir com metódos publicos do php. (o Composer precisa disso!)
 */

use Budgetlance\Controller\Cliente\ControllerCliente;
use Budgetlance\Controller\Controller;

class ControllerSite extends Controller
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
                IMAGES_SITE_URL . "Erro/erro404.jpg"
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
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);
    }

    public static function clienteDashboard()
    {
        parent::isProtected();
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Dashboard/ClienteDashboard";
        $controllerCliente = new ControllerCliente();
        $clientes = $controllerCliente->listarClientes();

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
}