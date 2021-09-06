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

    // Lista todas as compras do usuário
    public function listaComprasUsu(){
        $sql = 'SELECT * FROM compra WHERE usuario_id = ? AND ecommerce_id = ? ORDER BY compra_id DESC';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['login_cliente_ecommerce']);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }

        return false;
    }

    // Lista uma determinada compra do usuário
    public function listaCompraUsu($id){
        $sql = 'SELECT * FROM produto p
                JOIN compra_prod cp
                ON p.produto_id = cp.produto_id
                JOIN compra c 
                ON c.compra_id = cp.compra_id
                JOIN transacao_compra tc
                ON c.compra_id = tc.compra_id
                WHERE c.ecommerce_id = ? AND c.usuario_id = ? AND c.compra_id = ?';
         $sql = $this->db->prepare($sql);
         $sql->bindValue(1, $_SESSION['id_sub_dom']);
         $sql->bindValue(2, $_SESSION['login_cliente_ecommerce']);
         $sql->bindValue(3, $id);
         $sql->execute();
 
         if($sql->rowCount() > 0){
             return $sql->fetchAll();
         }
 
         return false;
    }

}

