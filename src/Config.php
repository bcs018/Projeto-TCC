<?php
namespace src;

define('BASE_ASS', '/assets/sitePrincipal/');
define('BASE_ASS_C', '/assets/commerce/');
define('BASE_URL', 'http://potlid.com.br');

//Configurações do paypal
// $GLOBALS['pagseguro_seller'] = 'bwcommerce@outlook.com';

// \PagSeguro\Library::initialize();
// \PagSeguro\Library::cmsVersion()->setName("BW Commerce")->setRelease("1.0.0");
// \PagSeguro\Library::moduleVersion()->setName("BW Commerce")->setRelease("1.0.0");

//Ambiente de produção = sandbox(pgm de teste)
// \PagSeguro\Configuration\Configure::setEnvironment('sandbox');
// //O token voce pega na url sandbox.pagseguro.uol.com.br, faz login, em Perfis de integração clica em Vendedor, la vai ter o token
// \PagSeguro\Configuration\Configure::setAccountCredentials('bwcommerce@outlook.com', '23E3EEF82A4046C5826279C0A3D2A541');
// \PagSeguro\Configuration\Configure::setCharset('UTF-8');
// \PagSeguro\Configuration\Configure::setLog(true, 'pagseguro.log');

//Configurações do Gerencianet - Boleto
$GLOBALS['gerencianet_clientid']     = 'Client_Id_45d786d57022418c71a1feb6ad04879689729f59';
$GLOBALS['gerencianet_clientsecret'] = 'Client_Secret_6d7692cf8197942b09eceea1b155981c39825d29';
$GLOBALS['gerencianet_sandbox']      = true;

class Config {
    const BASE_DIR = '/projeto-tcc';

    const DB_DRIVER   = 'mysql';
    const DB_HOST     = 'localhost';
    const DB_DATABASE = 'ecommerce';
    const DB_USER     = 'root';
    const DB_PASS     = '';

    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION   = 'index';    
    const URL_DEFAULT      = 'bw.com.br';
}

