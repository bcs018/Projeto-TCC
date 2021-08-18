<?php 

namespace src\models\commerce;

use \core\Model;
use \src\models\commerce\Carrinho;

class Info extends Model{

    // Pega todas as informações do site do ecommerce definido na url
    public function pegaDadosCommerce($sub){
        $sql = "SELECT * FROM ecommerce_usu eu
                JOIN ecom_usua ecus
                ON eu.ecommerce_id = ecus.ecommerce_id
                JOIN usuario u 
                ON u.usuario_id = ecus.usuario_id
                WHERE u.tp_usuario = 1 AND eu.sub_dominio = 'capas'";
        //$sql = "SELECT * FROM ecommerce_usu WHERE sub_dominio = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $sub);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }

        return false;
    }    

}