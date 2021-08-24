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

}

