<?php

/**
 * Essa função/arquivo serve para carregar o arquivo .env, pois o php puro nao consegue ler o .env sozinho
 * a função loadEnv vai receber um parametro que carrega o caminho para chegar no arquivo.
 * 
 */

function loadEnv($path){

    /**
     * Verifica se o arquivo existe, se não existir ele joga o erro
     * Sobre o erro(interessante para mim que nunca tratei em PHP):
     * 
     * throw: ativa uma excessão (um erro controlado)
     * Exception: classe padrão do PHP para representar erro
     * 
     */
    if(!file_exists($path)){
        throw new Exception("Arquivo .env não foi encontrado em {$path}");
    }

    /**
     * file serve para ler conteúdo de arquivo retornando um array de linhas
     * ex:
     * 
     * se .env tiver:
     * DB_HOST=spacehost
     * DB_PORT=8000
     * RANDOMBULLSHITGO=2133721931749187
     * 
     * $lines vira ["DB_HOST=spacehost", "DB_PORT=8000", "RANDOMBULLSHITGO=2133721931749187"]
     * 
     * FILE_IGNORE_NEW_LINES faz com que remova qualquer -> \n <- no final de cada linha
     * FILE_SKIP_EMPTY_LINES pula qualquer linha que esteja vazia.
     */
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    //percorre cada item ou indice de um array
    // $line = cada linha do .env
    foreach($lines as $line){

        /**
         * strpos faz a leitura da linha e conta os caracteres como numeros de itens dentro de um array,
         * retornando a posição da primeira ocorrência(aparição) de um caractere especifico em uma string.
         * 
         * então se strpos('palmeiras_nao_tem_mundial', 'p') -> 0 (Achou no começo)
         * ou strpos('palmeiras_nao_tem_mundial', 'a') -> 1 (a primeira ocorrência na frase onde achou)
         * 
         * se a linha começar com #, é por que é comentario. Então será usado o "continue" para pular a linha.
         * 
         * trim remove espaços em branco do inicio e fim de uma STRING
         * Exemplo: " oi " → "oi".
         */
        if(strpos(trim($line), '#') === 0) continue;

        /**
         * "explode" estoura um caractere especifico dentro de uma string e os separa em partes.
         * ex:
         *  explode("=", "DB_HOST=localhost") -> ["DB_HOST", "localhost"]
         * 
         * O 2 limita o quanto deve ser dividido(garantindo que apenas quebre em dois pedaços)
         * 
         * list atribui valores de um array diretamente em variaveis
         * ou seja:
         * 
         * o explode explodiu a string da linha e colocou os valores separados em array
         * aí o list pega a ordem dos itens e atribui a variavel pra cada um
         * 
         * ex:
         *  list($a, $b) = ["x", "y"]; -> $a = "x"; $b = "y";
         * 
         * dessa maneira:
         *  $name = "DB_HOST" e $value = "localhost"
         */
        list($name, $value) = explode('=', $line, 2);

        $name = trim($name);
        $value = trim($value);

        /**
         *  Aqui, além de espaços, ele remove aspas (" ou ') do início e fim.
         * 
         * ex:
         *  "\"localhost\"" -> "localhost"
         *  "'root'" -> "root"
         * 
         * ajuda quando a pessoa escrever valores ou chaves no estilo json sem querer
         * ex:
         *  DB_PASS="1234" -> DB_PASS=1234
         */
        $value = trim($value, "\"'");

        /**
         * define variavel de ambiente no php
         * 
         * ex:
         * 
         *  putenv("DB_HOST=localhost");
         *  echo getenv("DB_HOST"); // "localhost"
         */
        putenv("{$name}={$value}");

        /**
         * salva na superglobal $_ENV tambem
         * permitindo o acesso por:
         * 
         * echo $_ENV['DB_HOST'];
         */
        $_ENV[$name] = $value;

        /**
         * Faz a mesma coisa, mas no $_SERVER.
         * 
         * Motivo: alguns frameworks ou libs olham $_SERVER em vez de $_ENV!
         */
        $_SERVER[$name] = $value;


        

    }
}