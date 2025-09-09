<?php

namespace Budgetlance\Controller\Site;
/**
 * namespace serve pra definir caminhos para autoload de classes e para nao se confundir com metódos publicos do php. (o Composer precisa disso!)
 */

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

    public static function dashboard()
    {
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Dashboard/Dashboard";
        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Dashboard de gerenciamento geral",
            "pageCss" => [
                CSS_SITE_URL . "Dashboard/Dashboard.css"
            ],
            "pageImages" => [
                IMAGES_SITE_URL . "Dashboard/DashboardBackground.jpg"
            ],
            "pageJs" => [
                JS_SITE_URL . "Dashboard/Dashboard.js"
            ],
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);
    }
}