<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Cadastro;

class CadastroController extends Controller {

    public function index() {
        $cadastro = new Cadastro;
        $estados = $cadastro->lista_estados();

        $this->render('sitePrincipal/crialoja', ['estados'=>$estados]);
    }

    public function inserir(){
        $message['message']='';
        if (!$_POST['nome_usu'] || !$_POST['sobrenome_usu'] || !$_POST['email_usu']  || 
            !$_POST['celular']  || !$_POST['cpf_usu']       || !$_POST['data_nasc']  || 
            !$_POST['rua_usu']  || !$_POST['bairro_usu']    || !$_POST['num_usu']    || 
            !$_POST['cep_usu']  || !$_POST['estado_usu']    || !$_POST['subdominio'] || !$_POST['nome_fan']) 
            {

            $message['message'] = '<div class="alert alert-danger" role="alert">
                                        Existem campos obrigatórios não preenchidos, preencha novamente!
                                   </div>';
            
            echo json_encode( $message );
            exit;                        
        }

        $cadastro = new Cadastro;        
        $dados = $cadastro->inserir_cad($_POST);

        if($dados == ''){
            /*$message['message'] = '<div class="alert alert-success" role="alert">
                                        Cadastro efetuado com sucesso! clique em "Próximo" para proseguir <a href="/crie-sua-loja/pagamento"> <strong> Próximo </strong> </a>
                                   </div>';*/
            echo json_encode( ['message'=>1] );
            exit;
        }else{
            echo json_encode( $dados );
            exit;
        }

        /**
         * A partir daqui será jogado para outra pagina para assinar os planos $$$
         */
        header("Location: ". $_SERVER['HTTP_REFERER']);
        exit;

    }

}