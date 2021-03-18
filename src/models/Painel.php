<?php 

namespace src\models;
use \core\Model;

class Painel extends Model{
    public function alterarUsuario($id, $nome, $senha_atu, $senha_nov, $senha_rep, $foto){
        $sql = "SELECT * FROM usuario_admin WHERE usuarioadm_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = "UPDATE usuario_admin SET (nome_user, senha, url_foto)"
        }

        return $sql->fetch();
    }

    public function listaDadosPlano($id){
        $sql = "SELECT e.ecommerce_id, e.usuario_id, e.plano_id, e.sub_dominio, e.nome_fantasia, p.nome_plano, p.descricao_plano, p.preco, p.plano_id 
                FROM ecommerce_usu  e
                LEFT JOIN plano p 
                ON e.plano_id = p.plano_id
                WHERE e.usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        return $sql->fetch(); 
    }
}