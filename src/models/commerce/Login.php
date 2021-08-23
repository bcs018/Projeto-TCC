<?php 

namespace src\models\commerce;

use \core\Model;

class Login extends Model{

    // Verifica login do Empreendedor
    public function loginAction($sub, $login, $senha){
        $sql = "SELECT eu.ecommerce_id, eu.sub_dominio, eu.nome_fantasia, u.usuario_id, u.nome, u.cpf, u.senha FROM ecommerce_usu eu
                JOIN ecom_usua ecu
                ON ecu.ecommerce_id = eu.ecommerce_id
                JOIN usuario u 
                ON u.usuario_id = ecu.usuario_id
                WHERE eu.sub_dominio = ? AND u.login = ? AND u.senha = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $sub);
        $sql->bindValue(2, addslashes($login));
        $sql->bindValue(3, md5($senha));
        $sql->execute();

        $dados = $sql->fetch();

        if($sql->rowCount() > 0){
            $_SESSION['log_admin_c']['fantasia'] = $dados['nome_fantasia'];
            $_SESSION['credencial'] = $login;

            return true;
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Login e/ou Senha inválidos!
                                </div>';
        $_SESSION['credencial'] = $login;
        $_SESSION['log_admin_c'] = false;

        return false;
    }

    // Verifica login do cliente do ecommerce
    public function loginCAction($login, $senha, $control){
        //print_r($control);exit;

        $sql = "SELECT * FROM usuario_ecommerce ue
                JOIN eco_usu eu
                ON ue.ue_id = eu.usuario_id
                JOIN ecommerce_usu ecus
                ON ecus.ecommerce_id = eu.ecommerce_id
                WHERE ecus.ecommerce_id = ? AND (ue.email_ue = ? OR ue.login_ue = ?) AND ue.senha_ue = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $login);
        $sql->bindValue(3, $login);
        $sql->bindValue(4, md5($senha));
        $sql->execute();

        if($sql->rowCount() > 0){
            $idUsu = $sql->fetch();
            $_SESSION['login_cliente_ecommerce'] = $idUsu['ue_id'];

            // Variavel de controle para quando o usuario clicar no LOGIN entrar no painel de controle, e quando ele for fazer uma compra e nao
            // estiver logado, o control vai ser '' e o levara para a pagina anterior
               
            if(count($control) == 0){
                echo json_encode(['login'=>true, 'control'=>false]);
                exit;
            }
            echo json_encode(['login'=>true, 'control'=>true]);
            exit;
        }
            echo json_encode(['login'=>false]);
            exit;
    }
}