<?php

namespace Src\Controller\Site\Home;
/**
 * namespace serve pra definir caminhos para autoload de classes e para nao se confundir com metódos publicos do php. (o Composer precisa disso!)
 */

use Src\Controller\Controller;

class HomeController extends Controller
{

    public static function home()
    {
        
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Home/PaginaInicial";
        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Conheça a Budgetlance!",
            "pageCss" => [CSS_SITE_URL . "Home/PaginaInicial.css"],
            "pageImages" => [IMAGES_SITE_URL . "Home/..."],
            "pageJs" => [JS_SITE_URL . "Home/PaginaInicial.js"],
        ];

        parent::renderSiteView($viewFile, $configGeralDaPagina);

    }
}