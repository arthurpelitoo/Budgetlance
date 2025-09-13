<?php

use Budgetlance\Controller\Cliente\ControllerCliente;
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
        ControllerSite::mainDashboard();
    break;

    case "/dashboard/cliente":
        ControllerSite::clienteDashboard();
    break;

    case "/dashboard/cliente/form":
        ControllerSite::clienteForm();
    break;

    case "/dashboard/cliente/form/salvar":
        $authentication = new ControllerCliente();
        $authentication->salvarCliente();
    break;

    case "/dashboard/cliente/deletar":
        $authentication = new ControllerCliente();
        $authentication->deletarCliente();
    break;

    default:
        ControllerSite::erro404();
        echo "erro404";
    break;
}

// $routes = [
//     "GET" => [
//         "/" => [ControllerSite::class, "home"],
//         "/signUp" => [ControllerSite::class, "signUp"],
//         "/login" => [ControllerSite::class, "login"],
//         "/login/logout" => [ControllerUsuario::class, "logoutUsuario"],
//         "/dashboard" => [ControllerSite::class, "mainDashboard"],
//         "/dashboard/cliente" => [ControllerSite::class, "clienteDashboard"],
//         "/dashboard/cliente/form" => [ControllerSite::class, "clienteForm"],
//     ],
//     "POST" => [
//         "/login/form/verificar" => [ControllerUsuario::class, "loginUsuario"],
//         "/signUp/form/salvar" => [ControllerUsuario::class, "salvarUsuario"],
//         "/dashboard/cliente/salvar" => [ControllerCliente::class, "salvarCliente"],
//     ],
// ];

// $method = $_SERVER['REQUEST_METHOD'];
// $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// if (isset($routes[$method][$url])) {
//     [$controller, $action] = $routes[$method][$url];
//     (new $controller())->$action();
// } else {
//     ControllerSite::erro404();
// }
?>