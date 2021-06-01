<?php 

namespace src\models\commerce;

use \core\Model;

class Admin extends Model{

    public function verificarLogin($sub, $login, $senha){
        $sql = "SELECT eu.ecommerce_id, eu.sub_dominio, eu.nome_fantasia, u.usuario_id, u.nome, u.cpf, u.senha FROM ecommerce_usu eu
                JOIN usuario u 
                ON eu.usuario_id = u.usuario_id
                WHERE eu.sub_dominio = ? AND cpf = ? AND senha = ?";
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
                                    CPF e/ou Senha inválidos!
                                </div>';
        $_SESSION['credencial'] = $login;
        $_SESSION['log_admin_c'] = false;

        return false;
    }

    public function listaDados($sub){
        $sql = "SELECT eu.ecommerce_id, eu.sub_dominio, eu.nome_fantasia, u.usuario_id, u.nome, u.cpf, u.senha FROM ecommerce_usu eu
                JOIN usuario u 
                ON eu.usuario_id = u.usuario_id
                WHERE eu.sub_dominio = ? AND u.cpf = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $sub);
        $sql->bindValue(2, $_SESSION['credencial']);
        $sql->execute();

        if($sql->rowCount() == 0){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Algo deu errado, faça login novamente!
                                    </div>';
            return false;
        }

        return $sql->fetch();
    }

}