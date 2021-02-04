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
        /*if (!$_POST['nome_usu'] || !$_POST['sobrenome_usu'] || !$_POST['email_usu']  || 
            !$_POST['celular']  || !$_POST['cpf_usu']       || !$_POST['data_nasc']  || 
            !$_POST['rua_usu']  || !$_POST['bairro_usu']    || !$_POST['num_usu']    || 
            !$_POST['cep_usu']  || !$_POST['estado_usu']    || !$_POST['subdominio'] || !$_POST['nome_fan']) 
            {

            $_SESSION['error'] = ['<div class="alert alert-danger" role="alert">
                                        Existem campos obrigatórios não preenchidos, preencha novamente!
                                   </div>'];

            header("Location: ". $_SERVER['HTTP_REFERER']);
            exit;            
        }*/

        $cadastro = new Cadastro;

        //Testando o retorno!!!
        

        if($cadastro->inserir_cad($_POST)){
            echo "OK;"; 
        }else{
            echo "N OK";
        }
        exit;

        /**
         * A partir daqui será jogado para outra pagina para assinar os planos $$$
         */
        header("Location: ". $_SERVER['HTTP_REFERER']);
        exit;

    }

}