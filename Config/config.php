<?php

/**
 * Caminhos de diretorio
 */

/**
 * dirname(__DIR__) pega a partir do caminho do src (como se fosse um caminho base pra seguir.)
 *  ex: A:\...\htdocs\Servicelance\src
 * 
 * dirname(__DIR__) funciona com os arquivos View.php em qualquer estagio do desenvolvimento, porém,
 *  com arquivos css, js e imagens isso não funciona no estagio de produção,
 *  por causa que o HTML precisa do caminho relativo à raiz do servidor web, caminho público!
 *  ex: /Public/css/site/...
 */

/**
 * _____________________________________________________________
 *  // Caminho físico (que o PHP consegue dar require):
 * _____________________________________________________________
 */

/**
 * define o caminho base para a View/Site
 */
    $viewSiteBasePath = $_ENV['VIEW_SITE_PATH'];
    define('VIEW_SITE_PATH', dirname(__DIR__) . $viewSiteBasePath);

/**
 * define o caminho base para a View/templates
 */
    $viewTemplatesBasePath = $_ENV['VIEW_TEMPLATES_PATH'];
    define('VIEW_TEMPLATES_PATH', dirname(__DIR__) . $viewTemplatesBasePath);

/**
 * _____________________________________________________________
 *  // Caminho público (para HTML onde php não consegue dar require no servidor web):
 * _____________________________________________________________
 */

/**
 * define o caminho base para o css da View SITE
 * CSS_SITE_URL
 */
    $cssSiteBasePath = $_ENV['CSS_SITE_URL'];
    define('CSS_SITE_URL', $cssSiteBasePath);

/**
 * define o caminho base para o css do template padrão
 * CSS_TEMPLATE_URL
 */
   $cssTemplateBasePath = $_ENV['CSS_TEMPLATE_URL'];
   define('CSS_TEMPLATE_URL', $cssTemplateBasePath);

/**
 * define o caminho base para o images da View
 * IMAGES_SITE_URL
 */
    $imagesSiteBasePath = $_ENV['IMAGES_SITE_URL'];
    define('IMAGES_SITE_URL', $imagesSiteBasePath);

/**
 * define o caminho base para o images do template padrão
 * IMAGES_TEMPLATE_URL
 */
   $imagesTemplateBasePath = $_ENV['IMAGES_TEMPLATE_URL'];
   define('IMAGES_TEMPLATE_URL', $imagesTemplateBasePath);

/**
 * define o caminho base para o javascript da View
 * JS_SITE_URL
 */
    $jsSiteBasePath = $_ENV['JS_SITE_URL'];
    define('JS_SITE_URL', $jsSiteBasePath);

/**
 * define o caminho base para o javascript do template padrão
 * JS_TEMPLATE_URL
 */
   $jsTemplateBasePath = $_ENV['JS_TEMPLATE_URL'];
   define('JS_TEMPLATE_URL', $jsTemplateBasePath);

/**
 * Dados de Conexão ao banco de dados.
 */

    $_ENV['db']['host'] = $_ENV['DB_HOST'] . ":" . $_ENV['DB_PORT'];
    $_ENV['db']['user'] = $_ENV['DB_USER'];
    $_ENV['db']['pass'] = $_ENV['DB_PASS'];
    $_ENV['db']['database'] = $_ENV['DB_NAME'];