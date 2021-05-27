<?php 

namespace src\models\commerce;

use \core\Model;

class Admin extends Model{

    public function verificarLogin($sub){
        $sql = "SELECT * FROM ecommerce_usu WHERE sub_dominio = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $sub);
        $sql->execute();

        $dados = $sql->fetch();

        $sql = "SELECT * FROM usuario WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $dados['usuario_id']);
        $sql->execute();

        $usu = $sql->fetch();

        // Verificar se o CPF e senha bate pego pelo select acima bate com o CPF e senha informado

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }

        return false;
    }

}