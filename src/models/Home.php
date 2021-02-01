<?php 

namespace src\models;
use \core\Model;

class Home extends Model{

    public function get_tenant($dominio=0){
        /*$sub_dominio = explode('.', $dominio);
        if($sub_dominio[0] == 'projetotcc'){
            echo "SITE PRINCIPAL";
        }else{
            $sql = "SELECT * FROM usuarios WHERE tenant_id = :tenant_id";
            $sql = $this->connection->prepare($sql);
            $sql->bindValue(':tenant_id', $sub_dominio[0]);
            $sql->execute();
    
            if($sql->rowCount() > 0){
                $array = $sql->fetchAll();
            }
            return $array;
    
        }*/
    }

}
