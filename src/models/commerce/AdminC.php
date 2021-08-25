<?php 

namespace src\models\commerce;

use \core\Model;

class AdminC extends Model{

    public function listaDados($sub){
        $sql = "SELECT * FROM ecommerce_usu eu
                JOIN eco_usu ecu
                ON eu.ecommerce_id = ecu.ecommerce_id
                JOIN usuario_ecommerce ue 
                ON ue.ue_id = ecu.usuario_id
                WHERE eu.sub_dominio = ? AND ue.login_ue = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $sub);
        $sql->bindValue(2, $_SESSION['credencial']);
        $sql->execute();
        //echo $_SERVER['REQUEST_URI']; exit;

        if($sql->rowCount() == 0){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Faça login para continuar!
                                    </div>';
            return false;
        }

        return $sql->fetch();
    }

    public function ediDadosPessoaisAction($nome, $sobrenome, $celular, $senha='', $senhaRep=''){
        if(empty($nome) || empty($sobrenome) || empty($celular)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Campos obrigatórios não preenchidos!
                                    </div>';
            return false;
        }

        if(!empty($senhaRep) && !empty($senha)){
            if($senha != $senhaRep){
                $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                            Senhas não batem!
                                        </div>';
                return false;
            }

            $sql = 'UPDATE usuario_ecommerce SET nome_usu_ue = ?, sobrenome = ?, celular_ue = ?, senha_ue = ? WHERE ue_id = ?';
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $nome);
            $sql->bindValue(2, $sobrenome);
            $sql->bindValue(3, $celular);
            $sql->bindValue(4, md5($senha));
            $sql->bindValue(5, $_SESSION['login_cliente_ecommerce']);


            if($sql->execute()){
                $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                            Alteração feita com sucesso!
                                        </div>';
                return true;
            }

            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                            Ocorreu erro 001 ao fazer alteração!
                                        </div>';
            return false;

        }

        $sql = 'UPDATE usuario_ecommerce SET nome_usu_ue = ?, sobrenome = ?, celular_ue = ? WHERE ue_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nome);
        $sql->bindValue(2, $sobrenome);
        $sql->bindValue(3, $celular);
        $sql->bindValue(4, $_SESSION['login_cliente_ecommerce']);

        if($sql->execute()){
            $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                        Alteração feita com sucesso!
                                    </div>';
            return true;
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Ocorreu erro 002 ao fazer alteração!
                                    </div>';
            return false;
    }

}

