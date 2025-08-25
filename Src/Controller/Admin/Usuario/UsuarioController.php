<?php

namespace Src\Controller\Admin\Usuario;
/**
 * namespace serve pra definir caminhos para autoload de classes e para nao se confundir com metódos publicos do php. (o Composer precisa disso!)
 */

use Src\Controller\Controller;
use Src\Model\Admin\UsuarioModel;

class UsuarioController extends Controller
{

    public static function formUsuario()
    {
        
        // nome da pasta/arquivo.php View para ser passado.
        $viewFile = "Usuario/formUsuario";
        // configuracao geral para a pagina a ser gerada. 
        $configGeralDaPagina = [
            "title" => "Budgetlance Form de Usuario",
            "pageCss" => [CSS_ADMIN_URL . "Usuario/formUsuario.css"],
            "pageImages" => [IMAGES_ADMIN_URL . "Usuario/..."],
            "pageJs" => [JS_ADMIN_URL . "Usuario/formUsuario.js"],
        ];

        parent::renderAdminView($viewFile, $configGeralDaPagina);

    }
}