<?php 

// Define o namespace da classe. Isso organiza o código e evita conflito de nomes
namespace Budgetlance\Config;

// Importa a classe ControllerSite para usar dentro do roteador
use Budgetlance\Controller\Site\ControllerSite;

/**
 * Classe final (não pode ser herdada) que representa um roteador básico.
 * Ela é responsável por registrar rotas e despachar a requisição para a ação correta.
 */
final class Routes
{
    // Armazena todas as rotas registradas na aplicação.
    // Cada rota é um array com: [method, pattern, action].
    private array $routes = [];

    /**
     * Adiciona uma nova rota ao roteador.
     * 
     * @param string $method  O método HTTP da rota (GET, POST, PUT, DELETE...).
     * @param string $pattern O padrão da URL, escrito em regex.
     * @param callable $action O metodo de algum controller que vai ser chamado.
     */
    public function add(string $method, string $pattern, callable $action): void
    {
        /**
         * ele guarda todas as rotas dentro de um array associativo
         */
        $this->routes[] = [
            // Normaliza o método HTTP para sempre maiúsculo (ex: get → GET).
            'method'  => strtoupper($method),

            // Converte o pattern em regex. 
            // O "^" força a casar desde o início da string.
            // O "$" força a casar até o fim da string.
            // Exemplo: "/clientes/(\d+)" vira "#^/clientes/(\d+)$#"
            'pattern' => "#^" . $pattern . "$#",

            // A ação a ser executada quando a rota for encontrada.
            'action'  => $action
        ];
    }

    /**
     * Percorre todas as rotas registradas e tenta encontrar uma que bata
     * com a URL e método HTTP da requisição atual.
     * 
     * @param string $url    A URL requisitada (ex: "/clientes/123").
     * @param string $method O método HTTP atual (ex: GET, POST...).
     */
    public function dispatch(string $url, string $method): void
    {
        // Percorre todas as rotas registradas dentro do array associativo
        foreach ($this->routes as $route) {

            // Verifica se o método HTTP bate com o esperado
            // e se a URL casa com o padrão regex da rota
            if ($method === $route['method'] && preg_match($route['pattern'], $url, $matches)) {

                // O primeiro índice de $matches sempre é a string inteira que casou.
                // Exemplo: url "/clientes/123" → matches[0] = "/clientes/123"
                // matches[1] = "123". 
                // Como não precisamos do [0], removemos com array_shift.
                array_shift($matches);

                // Executa a ação definida para essa rota.
                // Se a rota tiver parâmetros capturados no regex, eles são enviados como argumentos.
                // Exemplo: fn($id) => deletarCliente($id)
                call_user_func_array($route['action'], $matches);

                // Encerra aqui para não continuar verificando outras rotas.
                return;
            }
        }

        // Se nenhuma rota foi encontrada, cai no 404.
        ControllerSite::erro404();
    }
}