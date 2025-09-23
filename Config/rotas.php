<?php

use Budgetlance\Config\Routes;
use Budgetlance\Controller\Categoria_Servico\ControllerCServico;
use Budgetlance\Controller\Site\ControllerSite;
use Budgetlance\Controller\Usuario\ControllerUsuario;
use Budgetlance\Controller\Cliente\ControllerCliente;
use Budgetlance\Controller\Orcamento\ControllerOrcamento;

/**
 * controle de rotas:
 *  url é o que pega depois da barra comum, ou seja: 
 *  youtube.com/videos
 *  vai pegar apenas o "videos"
 */

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

/**
 * é o metodo http de requisições, vai pegar qual é o metodo. Se é GET, POST, DELETE.
 */
$method = $_SERVER['REQUEST_METHOD'];

/**
 * Classe que faz todo o roteamento funcionar dinamicamente.
 */
$router = new Routes();

/**
 * as rotas get são as paginas comuns, ou seja, vai usar o ControllerSite.
 * as rotas post são as rotas que vão chamar os metodos necessarios para realizar alguma ação de inserção ou dar update.
 * as rotas delete são as rotas que vão chamar os metodos necessarios para realizar alguma ação de exclusão.
 */

// Rotas GET

$router->add("GET", "/", fn() => ControllerSite::home());
$router->add("GET", "/home", fn() => ControllerSite::home());
$router->add("GET", "/login", fn() => ControllerSite::login());

// O usuário não está enviando dados sensíveis, só dizendo "encerra minha sessão". Então aqui isso faz sentido dar GET.
$router->add("GET", "/login/logout", fn() => (new ControllerUsuario())->logoutUsuario());

$router->add("GET", "/signUp", fn() => ControllerSite::signUp());
$router->add("GET", "/dashboard", fn() => ControllerSite::mainDashboard());
$router->add("GET", "/dashboard/cliente", fn() => ControllerSite::clienteDashboard());
$router->add("GET", "/dashboard/cliente/form", fn() => ControllerSite::clienteForm());
$router->add("GET", "/dashboard/servico", fn() => ControllerSite::servicoDashboard());
$router->add("GET", "/dashboard/servico/form", fn() => ControllerSite::servicoForm());
$router->add("GET", "/dashboard/orcamento", fn() => ControllerSite::orcamentoDashboard());
$router->add("GET", "/dashboard/orcamento/form", fn() => ControllerSite::orcamentoForm());
// Rotas POST

$router->add("POST", "/login/form/verificar", fn() => (new ControllerUsuario())->loginUsuario());
$router->add("POST", "/signUp/form/salvar", fn() => (new ControllerUsuario())->salvarUsuario());

/**
 * aqui o salvarCliente decide se é Update ou Insert
 * então faz sentido ser post.
 */
$router->add("POST", "/dashboard/cliente/form/salvar", fn() => (new ControllerCliente())->salvarCliente());
$router->add("POST", "/dashboard/servico/form/salvar", fn() => (new ControllerCServico())->salvarCategoriaServico());
$router->add("POST", "/dashboard/orcamento/form/salvar", fn() => (new ControllerOrcamento())->salvarOrcamento());

// Rotas DELETE (dinâmica: /clientes/123) pega pelo id do cliente na "url".
$router->add("DELETE", "/dashboard/cliente/(\d+)", fn($id) => (new ControllerCliente())->deletarCliente($id));
$router->add("DELETE", "/dashboard/servico/(\d+)", fn($id) => (new ControllerCServico())->deletarCategoriaServico($id));
$router->add("DELETE", "/dashboard/orcamento/(\d+)", fn($id) => (new ControllerOrcamento())->deletarOrcamento($id));

// Despacha a rota
$router->dispatch($url, $method);

?>