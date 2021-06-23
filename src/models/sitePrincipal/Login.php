<?php 

namespace src\models\sitePrincipal;
use \core\Model;

class Login extends Model{

    public function validarLoginUser($senha, $user){
        $sql = "SELECT * FROM usuario WHERE cpf = ? AND senha = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $user);
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

    public function validarLoginAdmin($senha, $user){
        $sql = "SELECT * FROM usuario_admin WHERE login = ? AND senha = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $user);
        $sql->bindValue(2, md5($senha));
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = $sql->fetch();
            $_SESSION['log_admin']['id']   = $sql['usuarioadm_id'];
            $_SESSION['log_admin']['nome'] = $sql['nome_user'];
            $_SESSION['log_admin']['url_foto'] = $sql['url_foto'];

            return true;
        }

        return false;
    }
}