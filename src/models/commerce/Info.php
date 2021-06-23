<?php 

namespace src\models\commerce;

use \core\Model;

class Info extends Model{

    // Pega todas as informações do site do ecommerce definido na url
    public function pegaDadosCommerce($sub){
        $sql = "SELECT * FROM ecommerce_usu WHERE sub_dominio = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $sub);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }

        return false;
    }

}