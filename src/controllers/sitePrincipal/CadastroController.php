<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;
use \src\models\sitePrincipal\Cadastro;
use \src\models\sitePrincipal\Plano;

class CadastroController extends Controller {

    public function index() {
        $cadastro = new Cadastro;
        $estados = $cadastro->lista_estados();

        $this->render('sitePrincipal/crialoja', ['estados'=>$estados]);
    }

    public function pagamento(){
        $plano = new Plano;
        $planos = $plano->listarPlano();

        $this->render('sitePrincipal/pagamento', ['planos'=>$planos]);        
    }

    public function pagamentoPlano($pl){
        $plano = new Plano;
        $pl = $plano->pegarItem($pl['pl']);
        
        $this->render('sitePrincipal/pagamentoPlano',  ['plano'=>$pl]);        
    }

    public function inserir(){
        $message['message']='';
        if (!$_POST['nome_usu'] || !$_POST['sobrenome_usu'] || !$_POST['email_usu']  || !$_POST['cidade']    ||
            !$_POST['celular']  || !$_POST['cpf_usu']       || !$_POST['data_nasc']  || !$_POST['rep_senha'] ||
            !$_POST['rua_usu']  || !$_POST['bairro_usu']    || !$_POST['num_usu']    || !$_POST['senha']     ||
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

    public function inserirCadastroFree(){
        $pl = new Plano;
        $cd = new Cadastro;

        $pl->inserirPlano(1);
        $cd->ativarUsuario();

        $this->render('sitePrincipal/obrigado');        
    }

    public function verifica_cpf_cadastrado(){
        if(!$_POST['cpf_cad']){
            $message['message'] = '<div class="alert alert-danger" role="alert">
                                            CPF não preenchido!
                                    </div>';

            echo json_encode( $message );
            exit;     
        }

        $cadastro = new Cadastro;
        $dados = $cadastro->ver_cpf_cadastrado($_POST['cpf_cad']);

        if($dados == ''){
            echo json_encode( ['message'=>1] );
            exit;
        }else{
            echo json_encode( $dados );
            exit;
        }
    }

    public function consultarCep(){
        $cep = addslashes($_POST['cep']);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://viacep.com.br/ws/'.$cep.'/json/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $dados = curl_exec($ch);

        curl_close($ch);

        echo $dados;

        exit;
    }

    public function consultaSubDominio(){
        $sub = addslashes($_POST['sub']);

        $s = new Cadastro;

        if($s->consultaSub($sub)){
            echo json_encode(['message'=>true]);
            exit;
        }
        
        echo json_encode(['message'=>false]);
        exit;
    }

    public function consultaLogin(){
        $login = addslashes($_POST['login']);

        $log = new Cadastro;

        if($log->consultaLogin($login)){
            echo json_encode(['message'=>true]);
            exit;
        }

        echo json_encode(['message'=>false]);
        exit;
    }

}