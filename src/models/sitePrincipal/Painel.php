<?php 

namespace src\models\sitePrincipal;
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
        
        // if($dados['senha'] != md5($senha_atu)){
        //     return ['error'=>'Senha atual não bate com a cadastrada no sistema'];
        // }

        if(isset($foto['tmp_name']) && empty($foto['tmp_name'] == false )){
            $tpFoto = explode('/', $foto['type']);
            $nomeFoto = md5(time().rand(1,999)).'.'.$tpFoto[1];
            move_uploaded_file($foto['tmp_name'], '../assets/sitePrincipal/images/user_photo/'.$nomeFoto);

            $_SESSION['log_admin']['url_foto'] = $nomeFoto;
        }else{
            $nomeFoto = null;
        }

        if($sql->rowCount() > 0 && $senha_nov == '' && empty($foto['tmp_name'] )){
            $sql = "UPDATE usuario_admin SET nome_user = ? WHERE usuarioadm_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $nome);
            $sql->bindValue(2, $id);
            $sql->execute();

            $_SESSION['log_admin']['nome'] = $nome;
        }elseif($sql->rowCount() > 0 && $senha_nov == ''){
            $sql = "UPDATE usuario_admin SET nome_user = ?, url_foto = ? WHERE usuarioadm_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $nome);
            $sql->bindValue(2, $nomeFoto);
            $sql->bindValue(3, $id);
            $sql->execute();

            $_SESSION['log_admin']['nome'] = $nome;

        }else{
            $sql = "UPDATE usuario_admin SET (nome_user, senha, url_foto) VALUES (?,?,?)";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $nome);
            $sql->bindValue(2, md5($senha_nov));
            $sql->bindValue(3, $nomeFoto);
            $sql->execute();

            $_SESSION['log_admin']['nome'] = $nome;
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

    public function listaClientes(){
        $sql = 'SELECT * FROM ecommerce_usu eu
                JOIN ecom_usua eus
                ON eu.ecommerce_id = eus.ecommerce_id
                JOIN usuario u 
                ON u.usuario_id = eus.usuario_id
                JOIN plano p
                ON p.plano_id = eu.plano_id';
        $sql = $this->db->query($sql);

        return $sql->fetchAll();
    }

    public function qtdClientes(){
        $sql = "SELECT COUNT(*) AS 'qtd' FROM ecommerce_usu";
        $sql = $this->db->query($sql);

        return $sql->fetch();
    }

    public function qtdClientesHoje(){
        $sql = "SELECT COUNT(*) AS 'qtd' FROM ecommerce_usu WHERE data_cad = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, date('Y-m-d'));
        $sql->execute();

        return $sql->fetch();
    }

    public function altAtivo($id, $ativo){
        $sql = "UPDATE usuario SET ativo = ?
                WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $ativo);
        $sql->bindValue(2, $id);
        
        if($sql->execute()){
            return true;
        }
                
        return false;
    }

    public function relatorioVendas($data_ini, $data_fim){
        $dados['compras'] = '';
        $dados['mes']     = '';
        
        $sql = "SELECT SUM(a.valor_total) AS 'total', monthname(a.data_transacao) AS 'mes', year(a.data_transacao) AS 'ano' FROM ecommerce_usu eu 
                JOIN ecom_usua eus 
                ON eu.ecommerce_id = eus.ecommerce_id
                JOIN usuario u 
                ON u.usuario_id = eus.usuario_id 
                JOIN assinatura a 
                ON a.usuario_id = u.usuario_id 
                WHERE u.tp_usuario = ? AND a.data_transacao BETWEEN ? AND ?
                GROUP BY month(a.data_transacao), year(a.data_transacao)
                ORDER BY year(a.data_transacao), month(a.data_transacao);";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, 1);
        $sql->bindValue(2, $data_ini);
        $sql->bindValue(3, $data_fim);
        $sql->execute();

        $mes = '';

        if($sql->rowCount() > 0){
            foreach($sql->fetchAll() as $per){
                $mes .= "['".$per['mes']."',".$per['ano'].'],';
                $dados['total'][] = $per['total'];
            }

            $sql = "SELECT * FROM ecommerce_usu eu 
                    JOIN ecom_usua eus 
                    ON eu.ecommerce_id = eus.ecommerce_id
                    JOIN usuario u 
                    ON u.usuario_id = eus.usuario_id 
                    JOIN assinatura a 
                    ON a.usuario_id = u.usuario_id 
                    JOIN plano p 
                    ON p.plano_id = eu.plano_id
                    WHERE u.tp_usuario = ? AND a.data_transacao BETWEEN ? AND ?
                    ORDER BY year(a.data_transacao);";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, 1);
            $sql->bindValue(2, $data_ini);
            $sql->bindValue(3, $data_fim);
            $sql->execute();

            $dados['compras'] = $sql->fetchAll();
            $dados['mes']     = $mes;

            return $dados;
        }

        $dados['total'] = 0;

        $_SESSION['message'] = '<div class="alert alert-info" role="alert">
                                    Sem resultados nesse período, verifique o intervalo de datas!
                                </div>';

        return $dados;
    }

    public function addUsuario($nome, $login, $senha){
        $sql = "SELECT * FROM usuario_admin WHERE login = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $login);
        $sql->execute();

        if($sql->rowCount() > 0){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Já existe um usuário com esse login! <br>Informe outro
                                    </div>';
            return false;
        }

        $sql = "INSERT INTO usuario_admin (nome_user,login,senha)
                VALUES(?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nome);
        $sql->bindValue(2, $login);
        $sql->bindValue(3, md5($senha));
        $sql->execute();

        $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                    Usuário cadastrado com sucesso!
                                </div>';

        return true;
    }

    public function vendasPagar(){
        $sql = 'SELECT * FROM ecommerce_usu eu
                JOIN compra c
                ON eu.ecommerce_id = c.ecommerce_id
                JOIN ecom_usua eus
                ON eus.ecommerce_id = eu.ecommerce_id
                JOIN usuario u 
                ON eus.usuario_id = u.usuario_id
                WHERE c.recebido = ? AND c.transferido = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, 1);
        $sql->bindValue(2, 0);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }

        return false;               
    }

    public function vendaPagar($id){
        $sql = 'SELECT * FROM ecommerce_usu eu
                JOIN compra c
                ON eu.ecommerce_id = c.ecommerce_id
                JOIN ecom_usua eus
                ON eus.ecommerce_id = eu.ecommerce_id
                JOIN usuario u 
                ON eus.usuario_id = u.usuario_id
                WHERE c.recebido = ? AND c.compra_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, 1);
        $sql->bindValue(2, $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }

        return false;               

    }

    public function marcarTransferido($id, $tran){
        $sql = 'UPDATE compra SET transferido = ?
                WHERE compra_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $tran);
        $sql->bindValue(2, $id);
        $sql->execute();
    }

}