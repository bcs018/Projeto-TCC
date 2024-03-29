<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;
use \src\models\sitePrincipal\Painel;
use \src\models\sitePrincipal\Assinatura;
use src\models\sitePrincipal\InfoCadastro;

class InfoCadastroController extends Controller {
    public function index(){
        if(!isset($_SESSION['log'])){
            header("Location: /login");
            exit;
        }

        $info = new InfoCadastro;
        $ass = new Assinatura;
        
        $usu = $info->listaDadosUsuario($_SESSION['log']['id']);
        $plano = $info->listaDadosPlano($_SESSION['log']['id']);
        $assinatura = $ass->pegarItem($_SESSION['log']['id']); 
        $link_bol = $ass->pegarBoleto($assinatura['assinatura_id']);

        $dados = [
                  'usuario'    => $usu, 
                  'plano'      => $plano,
                  'assinatura' => $assinatura,
                  'link_bol'   => $link_bol                  
                 ];

        $this->render('sitePrincipal/infoCadastro', $dados);
    }
}