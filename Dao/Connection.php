<?php

namespace Budgetlance\Dao;

use \PDO;
use \PDOException;
use \RuntimeException;

abstract class Connection
//Data Access Object
{

    private static $instance;

    public static function getConnection()
    {
        /**
         * Se
         */
        if(!isset(self::$instance)){
            
            try{
                // o dsn tem que receber o host(que no caso é localhost e a porta aqui por enquanto) e tambem o nome do banco de dados
                $dsn = "mysql:host=" . $_ENV['db']['host']. ";dbname=" . $_ENV['db']['database'] . ";charset=utf8mb4";

                // o PDO(PHP Data Objects) Representa uma conexao entre o PHP e um banco de dados server. Ele pede ($dsn(data source name), nome do usuario no host, senha do host)
                self::$instance = new PDO(
                    $dsn,
                    $_ENV['db']['user'],
                    $_ENV['db']['pass'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch(PDOException $e){
                // apenas desenvolvedores veem  (grava no log do servidor).
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de conexão: " . $e->getMessage() . "\n");

                // mensagem simples que o usuario final vê
                throw new \RuntimeException("Erro interno. Tente novamente mais tarde.");
            }
        }
        return self::$instance;
    }

}

/**
 * ENCICLOPÉDIA Programada para ensinar e aprender!
 * O QUE PODE SE APRENDER NESSE ARQUIVO:
 */

/**
 * referente ao:
 * PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
 * 
 * Define como o PDO vai lidar com os erros. 
 * Por padrão o PDO não lança erro gritante, retornando apenas "false". O que é ruim, porque isso pode atrapalhar se não for percebido.
 * 
 * Usando essa opção, sempre que tiver B.O (ex: uma query invalida ou falha de conexão),
 * o PDO lançará uma exceção(PDOException), podendo tratar com try catch.
 */

/**
 * referente ao:
 * PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
 * 
 * Define o formato padrão quando buscar dados(fetch ou fetchAll)
 * PDO::FETCH_ASSOC -> retorna um array associativo (com nomes das colunas como chaves).
 * 
 * ex:
 *       $stmt = $pdo->query("SELECT id, nome FROM usuarios");
 *       $dados = $stmt->fetchAll(); // já vem como array associativo
 *       print_r($dados);
 *       
 *       Resultado:
 *       [
 *          [ "id" => 1, "nome" => "Maria" ],
 *          [ "id" => 2, "nome" => "João" ]
 *       ]
 * 
 * Outras opçoes seriam:
 * 
 * PDO::FETCH_NUM -> retorna um array numérico (0, 1, 2…).
 * PDO::FETCH_BOTH -> retorna os dois ao mesmo tempo (esse é o padrão do PDO se não mudar).
 * PDO::FETCH_OBJ -> retorna cada linha como um objeto em vez de array.
 */

/**
 * referente ao:
 * PDO::ATTR_EMULATE_PREPARES => false
 * 
 * Define se o PDO deve usar prepared statements reais do banco ou se ele vai "simular" isso no PHP.
 * 
 * Se true (emulação ativada): o PDO pega a query preparada e "monta" ela no PHP antes de mandar para o banco.
 * Se false: o PDO deixa o próprio banco de dados processar os parâmetros de forma nativa.
 * 
 * usando false porque é:
 *  Mais seguro contra SQL Injection (porque o banco faz o binding de variáveis).
 *  Mais fiel ao comportamento do banco real.
 *  E algumas features (como certos tipos de LIMIT, grandes números, etc.) funcionam melhor com prepare real.
 */
