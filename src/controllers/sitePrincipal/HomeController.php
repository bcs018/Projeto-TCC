<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;
use \src\models\sitePrincipal\Plano;
use \src\models\sitePrincipal\Xmlapi;

class HomeController extends Controller {

    public function index() {   
        $plano = new Plano;
        $planos = $plano->listarPlano();
   
        $this->render('sitePrincipal/home',  ['planos'=>$planos]);
    }

    public function sobre() {
        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

    public function create_subdomain(/*$subDomain,$cPanelUser,$cPanelPass,$rootDomain*/) {
        $subDomain = 'capas';
        $cPanelUser = 'epiz_29757064';
        $cPanelPass = '2f2W6fMGzB';
        $rootDomain = 'bwco.ml';

        /*------------------------ Subdomínio Criar ---------------*/
        
        //require("xmlapi.php"); //Chame a classe xmlapi 
        
        $cpanelusr  = 'epiz_29757064'; //nome de usuário cPanel
        $cpanelpass = '2f2W6fMGzb'; //Senha do usuário do CPanel
        
        $xmlapi     = new Xmlapi('185.27.134.3'); //Nós instanciamos a classe xmlapi passando como parâmetro 127.0.0.1
        
        $xmlapi->set_port( 2083 ); //A porta CPanel pode ser 2082 ou 2083
        
        $xmlapi->password_auth($cpanelusr,$cpanelpass); //Autenticação no cPanel
        
        $xmlapi->set_debug(1); //Saída de erro 1 = verdadeiro
        
        $json=$xmlapi->set_output('json'); //Converter mensagens api em formato json
        
        $result = $xmlapi->api1_query($cpanelusr, 'SubDomain', 'addsubdomain', array('oiaeu','bwco.ml',0,0, '/htdocs/olhaeu'));
        
        //Nós criamos o subdomínio
        $array = json_decode($result);
        
        //Converter dados json enviados pela API em uma matriz
        //$errors_api= $array->{'error'};
        print_r($array);exit;

        //Extraia a mensagem de erro
        if ($errors_api==null) {
          if ($result){
            $messages = 'OK'; //"O domínio <strong>$subdominio.$domain</strong> foi criado com sucesso.";
          }else{
            $errors = "Não foi possível criar subdomínio.";
          }
        }else{
          $errors = $errors_api;
        } /*------------------------ end SubDomain Criar ---------------*/ 

        echo $errors;
        echo $messages;
    }

}