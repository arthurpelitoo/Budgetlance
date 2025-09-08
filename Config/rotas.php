<?php

use Budgetlance\Controller\Site\ControllerSite;
use Budgetlance\Controller\Usuario\ControllerUsuario;

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// serve para ler o que está na url depois da barra

// controle de rotas
// se caso url for / entrega a pagina inicial e assim vai, ele checa os casos. Default é o que acontece se nenhum dos casos baterem.

switch($url)
{
    case "/":
        ControllerSite::home();
    break;

    case "/home":
        ControllerSite::home();
    break;

    case "/login":
        ControllerSite::login();
    break;

    case "/login/form/verificar":
        $authentication = new ControllerUsuario();
        $authentication->loginUsuario();
    break;

    case "/login/logout":
        $authentication = new ControllerUsuario();
        $authentication->logoutUsuario();
    break;

    case "/signUp":
        ControllerSite::signUp();
    break;

    case "/signup/form/salvar":
        $authentication = new ControllerUsuario();
        $authentication->salvarUsuario();
    break;

    case "/dashboard":
        ControllerSite::dashboard();
    break;

    default:
        http_response_code(404);
        echo "erro404";
    break;
}
?>