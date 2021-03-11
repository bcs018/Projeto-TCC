<?php 

namespace src\models;
use \core\Model;

class Login extends Model{

    public function validarLogin($senha, $cpf){
        $sql = "SELECT * FROM usuario WHERE cpf = ? AND senha = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $cpf);
        $sql->bindValue(2, md5($senha));
        $sql->execute();
        
        if($sql->rowCount() > 0){
            $sql = $sql->fetch();
            $_SESSION['log']['id']   = $sql['usuario_id'];
            $_SESSION['log']['user'] = $sql['nome'];

            return true;
        }

        return false;
    }

    public function validarLoginAdmin($senha, $login){
        
    }
}