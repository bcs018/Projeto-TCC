<?php 

namespace src\models\commerce;

use \core\Model;
use \src\models\commerce\Info;

/**
 * Classe de configuração do PagSeguro
 */

class PagSeguro extends Model{
    public static function setDados(){
        $info = new Info;
        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName($dados['nome_fantasia'])->setRelease("1.0.0");
        \PagSeguro\Library::moduleVersion()->setName($dados['nome_fantasia'])->setRelease("1.0.0");

        //Ambiente de produção = sandbox(pgm de teste)
        \PagSeguro\Configuration\Configure::setEnvironment('sandbox');
        //O token voce pega na url sandbox.pagseguro.uol.com.br, faz login, em Perfis de integração clica em Vendedor, la vai ter o token
        \PagSeguro\Configuration\Configure::setAccountCredentials($dados['ps_email'], $dados['ps_token']);
        \PagSeguro\Configuration\Configure::setCharset('UTF-8');
        \PagSeguro\Configuration\Configure::setLog(true, 'pagseguro.log');

        return $dados;
    }
} 