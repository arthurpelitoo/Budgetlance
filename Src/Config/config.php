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
    $viewSiteBasePath = '/View/Site/';
    define('VIEW_SITE_PATH', dirname(__DIR__) . $viewSiteBasePath);

/**
 * define o caminho base para a View/Admin
 */
    $viewAdminBasePath = '/View/Admin/';
    define('VIEW_ADMIN_PATH', dirname(__DIR__) . $viewAdminBasePath);

/**
 * define o caminho base para a View/templates
 */
    $viewTemplatesBasePath = '/View/templates/';
    define('VIEW_TEMPLATES_PATH', dirname(__DIR__) . $viewTemplatesBasePath);

/**
 * _____________________________________________________________
 *  // Caminho público (para HTML onde php não consegue dar require no servidor web):
 * _____________________________________________________________
 */

/**
 * define o caminho base para o css da View
 * CSS_ADMIN_URL
 */
    $cssAdminBasePath = '/Public/css/Admin/';
    define('CSS_ADMIN_URL', $cssAdminBasePath);

/**
 * define o caminho base para o css da View
 * CSS_SITE_URL
 */
    $cssSiteBasePath = '/Public/css/Site/';
    define('CSS_SITE_URL', $cssSiteBasePath);

/**
 * define o caminho base para o images da View
 * IMAGES_ADMIN_URL
 */
    $imagesAdminBasePath = '/Public/images/Admin/';
    define('IMAGES_ADMIN_URL', $imagesAdminBasePath);

/**
 * define o caminho base para o images da View
 * IMAGES_SITE_URL
 */
    $imagesSiteBasePath = '/Public/images/Site/';
    define('IMAGES_SITE_URL', $imagesSiteBasePath);

/**
 * define o caminho base para o javascript da View
 * JS_ADMIN_URL
 */
    $jsAdminBasePath = '/Public/js/Admin/';
    define('JS_ADMIN_URL', $jsAdminBasePath);

/**
 * define o caminho base para o javascript da View
 * JS_SITE_URL
 */
    $jsSiteBasePath = '/Public/js/Site/';
    define('JS_SITE_URL', $jsSiteBasePath);

/**
 * Dados de Conexão ao banco de dados.
 */

    $_ENV['db']['host'] = "localhost:3306";
    $_ENV['db']['user'] = "root";
    $_ENV['db']['pass'] = "";
    $_ENV['db']['database'] = "budgetlance";