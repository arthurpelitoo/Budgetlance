<?php 

require_once __DIR__ .'/../vendor/autoload.php';

use App\Controller\UserController;
use App\Controller\NotFoundController;

$uri = $_SERVER['REQUEST_URI'];

$pages = [
    '\FreeLancers' => new UserController()
];

$controller = $pages[$uri] ?? new NotFoundController();
$controller->render();

if ($uri == '/user00') {
    $userController = new UserController();
    $userController ->render();
}

header("Content-Type: application/json");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
 
$clientes = [
    ["id" => 1, "nome" => "Maria Silva", "contato" => "maria@email.com"],
    ["id" => 2, "nome" => "João Souza", "contato" => "joao@email.com"],
];

switch ($uri[0]) {
    case "clientes":
        if ($requestMethod == "GET") {
            echo json_encode($clientes);
        } elseif ($requestMethod == "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            $clientes[] = [
                "id" => count($clientes) + 1,
                "nome" => $data["nome"],
                "contato" => $data["contato"]
            ];
            echo json_encode(["mensagem" => "Cliente criado com sucesso"]);
        }
        break;

    case "orcamentos":
        if ($requestMethod == "GET") {
            echo json_encode([
                ["id" => 1, "cliente" => "Maria Silva", "total" => 3000, "status" => "Aprovado"]
            ]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["erro" => "Endpoint não encontrado"]);
        break;
    }
?>