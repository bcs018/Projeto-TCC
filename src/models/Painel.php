<?php 

namespace src\models;
use \core\Model;

class Painel extends Model{
    public function alterarUsuario($id, $nome, $senha_atu, $senha_nov, $senha_rep, $foto){
        if($nome == '' || empty($nome)){
            return ['error'=>'Nome em branco'];
        }
        
        if($senha_nov != $senha_rep){
            return ['error'=>'Novas senhas não conferem'];
        }

        $sql = "SELECT * FROM usuario_admin WHERE usuarioadm_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        $dados = $sql->fetch();
        
        if($dados['senha'] != md5($senha_atu)){
            return ['error'=>'Senha atual não bate com a cadastrada no sistema'];
        }

        if(isset($foto['tmp_name']) && empty($foto['tmp_name'] == false )){
            $tpFoto = explode('/', $foto['type']);
            $nomeFoto = md5(time().rand(1,999)).'.'.$tpFoto[1];
            move_uploaded_file($foto['tmp_name'], '../assets/sitePrincipal/images/user_photo/'.$nomeFoto);
        }else{
            $nomeFoto = null;
        }

        if($sql->rowCount() > 0 && $senha_nov == ''){
            $sql = "UPDATE usuario_admin SET (nome_user, url_foto) VALUES (?,?)";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $nome);
            $sql->bindValue(3, $nomeFoto);
        }else{
            $sql = "UPDATE usuario_admin SET (nome_user, senha, url_foto) VALUES (?,?,?)";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $nome);
            $sql->bindValue(2, md5($senha_nov));
            $sql->bindValue(3, $nomeFoto);
        }

        return 0;
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