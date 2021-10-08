<?php
namespace src\controllers\commerce;

use \core\Controller;
use PagSeguro\Resources\Responsibility\Configuration\File;
use \src\models\commerce\Admin;
use \src\models\commerce\Produto;
use \src\models\commerce\Marca;
use \src\models\commerce\Info;
use \src\models\commerce\Notificacao;

class AdminController extends Controller {

    // public function index() {
    //     $this->render('commerce/lay01/login_adm');
    // }

    // -- Função para pegar informações do ecommerce de cada cliente
    public static function listaDadosEcommerce(){
        $login = new Admin;

        $dados = $login->listaDados($_SESSION['sub_dom']);

        if($dados == false){
            header("Location: /admin");
            exit;
        }

        return $dados;
    } 

    // -- Pagina principal do painel de controle
    public function painel() {
        $dados = $this->listaDadosEcommerce();

        $adm = new Admin;

        $qtdUsu = $adm->listaQtdUsu();
        $qtdUsuHoje = $adm->listaQtdUsuHoje();

        $this->render('commerce/painel_adm/principal', ['qtdUsuHoje'=>$qtdUsuHoje, 'qtdUsu'=>$qtdUsu['qtd'],'control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
    }

    public function ediDadosPessoais(){
        $dados = $this->listaDadosEcommerce();
        $est = new Admin;
        
        $estados = $est->lista_estados();

        $this->render('commerce/painel_adm/edi_dados_pessoais', ['control_rec'=>$dados['tp_recebimento'],'dados'=>$dados, 'estados'=>$estados]);
    }

    public function addNovoUsu(){
        $dados = $this->listaDadosEcommerce();
        $est = new Admin;

        $estados = $est->lista_estados();

        $this->render('commerce/painel_adm/add_usuario', ['control_rec'=>$dados['tp_recebimento'], 'dados'=>$dados, 'estados'=>$estados]);
    }

    public function layout(){
        $dados = AdminController::listaDadosEcommerce();

        $pro = new Produto;
        $mar = new Marca;
        $inf = new Info;

        $dados    = $inf->pegaDadosCommerce($_SESSION['sub_dom']);
        $produtos = $pro->listaProdutos();
        $marcas   = $mar->listaMarcas();

        $this->render('commerce/painel_adm/layout', ['control_rec'=>$dados['tp_recebimento'], 'produtos'=>$produtos, 'marcas'=>$marcas, 'dados'=>$dados]);
    }

    public function cadDadosRecebimento(){
        $dados = AdminController::listaDadosEcommerce();

        $this->render('commerce/painel_adm/dados_recebimento', ['control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
    }

    // Relatórios de vendas
    public function relVendas(){
        $dados = AdminController::listaDadosEcommerce();
        $adm = new Admin;

        $ultimo_dia = date("t", mktime(0,0,0, date("m"),'01', date("Y")));

        /* Valores padrão para inicio do relatório */
        $plan1_ini = date("Y-m").'-01';        
        $plan2_ini = date('Y-m-d',strtotime(date('Y-m-d'). '-6 month'));
        $plan3_ini = $dados['data_cad'];
        $plan_fim  = date("Y-m").'-'.$ultimo_dia;
        /* */

        if($dados['plano_id'] == '1'){
            // Se for plano 1, envia somente o relatório do mes como padrão
            $rel = $adm->relatorioVendas($plan1_ini, $plan_fim, $dados['plano_id']);
            $data_ini = $plan1_ini;
        }else if($dados['plano_id'] == '2'){
            // Se for plano 2, envia 6 mes atras como padrão
            $rel = $adm->relatorioVendas($plan2_ini, $plan_fim, $dados['plano_id']);
            $data_ini = $plan2_ini;
        }else if($dados['plano_id'] == 3){
            // Se for plano 3, mostra desde a criação da loja como padrão]
            $rel = $adm->relatorioVendas($plan3_ini, $plan_fim, $dados['plano_id']);
            $data_ini = $plan3_ini;
        }

        $this->render('commerce/painel_adm/relatorios', ['ini'=>$data_ini, 'fim'=>$plan_fim, 'rel'=>$rel, 'control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
    }

    public function relVendasAction(){
        $dados = AdminController::listaDadosEcommerce();
        $adm = new Admin;

        $ultimo_dia = date("t", mktime(0,0,0, date("m"),'01', date("Y")));

        /* Valores padrão para inicio do relatório */
        $plan1_ini = date("Y-m").'-01';        
        $plan2_ini = date('Y-m-d',strtotime(date('Y-m-d'). '-6 month'));
        //$plan3_ini = $dados['data_cad'];
        $plan_fim  = date("Y-m").'-'.$ultimo_dia;
        /* */

        if(isset($_POST['data_fim']) && isset($_POST['data_ini'])){
            if(strtotime($_POST['data_fim']) < strtotime($_POST['data_ini'])){
                $rel = $adm->relatorioVendas(0, 0, $dados['plano_id']);
                $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                            Data final anterior a Data inicial!
                                        </div>';

                $this->render('commerce/painel_adm/relatorios', ['ini'=>$_POST['data_ini'], 'fim'=>$_POST['data_fim'], 'rel'=>$rel, 'control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
                exit;
            }
        }

        // Só vai entrar nesse if se mandar os POSTs com o intervalo entre datas
        if(isset($_POST['data_ini']) && !empty($_POST['data_ini']) && isset($_POST['data_fim']) && !empty($_POST['data_fim'])){
            if($dados['plano_id'] == '1'){
                if(date('m',strtotime($_POST['data_ini'])) < date('m')){
                    $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                                Você não pode escolher esse intervalo de data pois seu plano não permite! <br>
                                                Seu plano permite somente relatório do mês vigênte!
                                            </div>';
        
                    $rel = $adm->relatorioVendas($plan1_ini, $plan_fim, $dados['plano_id']);
                    $this->render('commerce/painel_adm/relatorios', ['ini'=>$plan1_ini, 'fim'=>$plan_fim, 'rel'=>$rel, 'control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
                    exit;
                }

                $rel = $adm->relatorioVendas($_POST['data_ini'], $_POST['data_fim'], $dados['plano_id']);
                $this->render('commerce/painel_adm/relatorios', ['ini'=>$_POST['data_ini'], 'fim'=>$_POST['data_fim'], 'rel'=>$rel, 'control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
                exit;

            }else if($dados['plano_id'] == '2'){
                $resul = strtotime($_POST['data_fim']) - strtotime($_POST['data_ini']);
                $resul = floor($resul/(60*60*24));

                if($resul > 183){
                    $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                                Você não pode escolher esse intervalo de data pois seu plano não permite! <br>
                                                Seu plano permite somente relatório de até seis meses!
                                            </div>';

                    $rel = $adm->relatorioVendas($plan2_ini, $plan_fim, $dados['plano_id']);
                    $this->render('commerce/painel_adm/relatorios', ['ini'=>$plan2_ini, 'fim'=>$plan_fim,'rel'=>$rel, 'control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
                    exit;

                }
                
                $rel = $adm->relatorioVendas($_POST['data_ini'], $_POST['data_fim'], $dados['plano_id']);
                $this->render('commerce/painel_adm/relatorios', ['ini'=>$_POST['data_ini'], 'fim'=>$_POST['data_fim'],'rel'=>$rel, 'control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
                exit;

            }else if($dados['plano_id'] == 3){
                $rel = $adm->relatorioVendas($_POST['data_ini'], $_POST['data_fim'], $dados['plano_id']);
                $this->render('commerce/painel_adm/relatorios', ['ini'=>$_POST['data_ini'], 'fim'=>$_POST['data_fim'],'rel'=>$rel, 'control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
                exit;
            }
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Preencha o intervalo de datas!
                                </div>';
        $rel = $adm->relatorioVendas(date("Y-m-d"), date("Y-m-d"), $dados['plano_id']);
        $this->render('commerce/painel_adm/relatorios', ['ini'=>date("Y-m-d"), 'fim'=>date("Y-m-d"),'rel'=>$rel, 'control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
        exit;
    }

    public function cadDadosRecebimentoAction(){
        $tknpagseguro   = addslashes($_POST['tknpagseguro']);
        $emailpagseguro = addslashes($_POST['emailpagseguro']);
        $pkmpago        = addslashes($_POST['pkmpago']);
        $tknmpago       = addslashes($_POST['tknmpago']);

        $admin = new Admin;

        $admin->cadDadosRecebimentoAction($tknpagseguro, $emailpagseguro, $pkmpago, $tknmpago);

        header("Location: /admin/painel/cadastrar-dados-recebimento");
    }

    public function ediLayoutAction(){
        $_SESSION['message'] = '';
        $adm = new Admin;
        $ban = new Produto;
        $mar = new Marca;

        if(isset($_POST['escolhaLay']) && !empty($_POST['escolhaLay'])){
            $adm->ediLayout(addslashes($_POST['escolhaLay']));
        }

        if(isset($_FILES['banner']) && !empty($_FILES['banner']['tmp_name'])){
            $ban->addBannerProdAction($_FILES['banner'], addslashes($_POST['produtoId']));
        }

        if(isset($_FILES['logo']) && !empty($_FILES['logo']['tmp_name'])){
            $adm->addLogoAction($_FILES['logo']);
        }

        if(isset($_FILES['ico']) && !empty($_FILES['ico']['tmp_name'])){
            $adm->addIcoAction($_FILES['ico']);
        }

        if(isset($_FILES['marca']) && !empty($_FILES['marca']['tmp_name'])){
            $mar->addImagemMarcaAction($_FILES['marca'], addslashes($_POST['marcaId']));
        }

        if(isset($_POST['cor']) || !empty($_POST['cor'])){
            $adm->addCorSec(addslashes($_POST['cor']));
        }

        if(isset($_POST['corRodape']) || !empty($_POST['corRodape'])){
            $adm->addCorRodape(addslashes($_POST['corRodape']));
        }

        
        header("Location: /admin/painel/layout");
    }

    public function addNovoUsuAction(){
        $nome        = addslashes($_POST['nome']);
        $sobrenome   = addslashes($_POST['sobrenome']);
        $login       = addslashes($_POST['login']);
        $email       = addslashes($_POST['email']);
        $celular     = addslashes($_POST['celular']);
        $cep         = addslashes($_POST['cep']);
        $rua         = addslashes($_POST['rua']);
        $bairro      = addslashes($_POST['bairro']);
        $numero      = addslashes($_POST['numero']);
        $cidade      = addslashes($_POST['cidade']);
        $estado      = addslashes($_POST['estado']);
        $complemento = addslashes($_POST['complemento']);
        $senha       = addslashes($_POST['senha']);
        $senhaRep    = addslashes($_POST['senhaRep']);

        $usu = new Admin;
        $usu->addNovoUsuAction($nome, $sobrenome, $login, $email, $celular, $cep, $rua, $bairro, $numero, $cidade, $estado, $complemento, $senha, $senhaRep);

        header("Location: /admin/painel/add-novo-usuario");

        exit;
    }

    public function ediDadosPessoaisAction(){
        $nome        = addslashes($_POST['nome']);
        $sobrenome   = addslashes($_POST['sobrenome']);
        $celular     = addslashes($_POST['celular']);
        $cep         = addslashes($_POST['cep']);
        $rua         = addslashes($_POST['rua']);
        $bairro      = addslashes($_POST['bairro']);
        $numero      = addslashes($_POST['numero']);
        $cidade      = addslashes($_POST['cidade']);
        $estado      = addslashes($_POST['estado']);
        $complemento = addslashes($_POST['complemento']);
        $senha       = addslashes($_POST['altSenha']);
        $senhaRep    = addslashes($_POST['altSenhaRep']);
        $idUsu       = addslashes($_POST['id']);

        $cep = explode('-', $cep);
        $cep = $cep[0].$cep[1];

        $edi = new Admin;
        $edi->ediDadosPessoaisAction($idUsu, $nome, $sobrenome, $celular, $cep, $rua, $bairro, $numero, $cidade, $estado, $complemento, $senha, $senhaRep);

        header("Location: /admin/painel/alterar-dados-pessoais");

        exit;
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
}