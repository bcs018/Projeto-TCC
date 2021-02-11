<?php
namespace src;

define('BASE_ASS', 'http://bw.com.br/assets/sitePrincipal/');

class Config {
    const BASE_DIR = '/projeto-tcc';

    const DB_DRIVER = 'mysql';
    const DB_HOST = 'localhost';
    const DB_DATABASE = 'ecommerce';
    CONST DB_USER = 'root';
    const DB_PASS = '';

    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';
    
    \PagSeguro\Library::initialize();
    \PagSeguro\Library::cmsVersion()->setName("BW Commerce")->setRelease("1.0.0");
    \PagSeguro\Library::moduleVersion()->setName("BW Commerce")->setRelease("1.0.0");

    //Ambiente de produção = sandbox(pgm de teste)
    \PagSeguro\Configuration\Configure::setEnvironment('sandbox');
    //O token voce pega na url sandbox.pagseguro.uol.com.br, faz login, em Perfis de integração clica em Vendedor, la vai ter o token
    \PagSeguro\Configuration\Configure::setAccountCredentials('email da conta pagseguro', 'token');
    \PagSeguro\Configuration\Configure::setCharset('UTF-8');
    \PagSeguro\Configuration\Configure::setLog(true, 'pagseguro.log');
}

