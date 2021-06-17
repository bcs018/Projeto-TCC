<?php 

namespace src\models\commerce;

use \core\Model;

class Admin extends Model{

    public function verificarLogin($sub, $login, $senha){
        $sql = "SELECT eu.ecommerce_id, eu.sub_dominio, eu.nome_fantasia, u.usuario_id, u.nome, u.cpf, u.senha FROM ecommerce_usu eu
                JOIN usuario u 
                ON eu.usuario_id = u.usuario_id
                WHERE eu.sub_dominio = ? AND cpf = ? AND senha = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $sub);
        $sql->bindValue(2, addslashes($login));
        $sql->bindValue(3, md5($senha));
        $sql->execute();

        $dados = $sql->fetch();

        if($sql->rowCount() > 0){
            $_SESSION['log_admin_c']['fantasia'] = $dados['nome_fantasia'];
            $_SESSION['credencial'] = $login;

            return true;
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    CPF e/ou Senha inválidos!
                                </div>';
        $_SESSION['credencial'] = $login;
        $_SESSION['log_admin_c'] = false;

        return false;
    }

    public function listaDados($sub){
        $sql = "SELECT eu.ecommerce_id, eu.sub_dominio, eu.nome_fantasia, u.usuario_id, u.nome, u.cpf, u.senha FROM ecommerce_usu eu
                JOIN usuario u 
                ON eu.usuario_id = u.usuario_id
                WHERE eu.sub_dominio = ? AND u.cpf = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $sub);
        $sql->bindValue(2, $_SESSION['credencial']);
        $sql->execute();

        if($sql->rowCount() == 0){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Algo deu errado, faça login novamente!
                                    </div>';
            return false;
        }

        return $sql->fetch();
    }

    public function cadCategoria($nomeCategoria, $subCategoira){
        if($subCategoira == 0){
            $sql = 'INSERT INTO categoria (nome_cat) VALUES (?)';
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $nomeCategoria);

            if($sql->execute())
                return true;
    
            return false;
        }

        $sql = 'SELECT * FROM categoria WHERE categoria_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $subCategoira);
        $sql->execute();

        if($sql->rowCount() > 0){
            
        }

    }

    public function cadProdutoActionFirst($nomeProd, $descProd, $estoque, $preco, $precoAnt, $promo, $novo){
        // echo $nomeProd.'<br>'; 
        // echo $descProd.'<br>'; 
        // echo $estoque .'<br>'; 
        // echo $preco   .'<br>'; 
        // echo $precoAnt.'<br>'; 
        // echo $promo   .'<br>'; 
        // echo $novo    .'<br>'; exit;

        $preco = str_replace(',','.',$preco);
        $preco = str_replace(' ','',$preco);
        $preco = floatval($preco);

        $precoAnt = str_replace(',','.',$precoAnt);
        $precoAnt = str_replace(' ','',$precoAnt);
        $precoAnt = floatval($precoAnt);

        $promo = intval($promo);
        
        if(empty($nomeProd) || empty($descProd) || empty($estoque) || empty($preco) || empty($precoAnt)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Existem campos não preenchidos!
                                    </div>';

            echo "Entrei aqui 1if";
            return false;
        }

        if(!is_numeric($estoque) || $estoque <= 0){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Estoque não numérico ou menor ou igual a ZERO!
                                    </div>';
            echo "Entrei aqui 2if";
            return false;
        }


        if(($promo < 0 || $promo > 1) || ($novo < 0 || $novo > 1)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Houve um problema ao adicionar o produto, atualize a página e tente novamente!
                                    </div>';
            return false;
        }

        // $sql = 'INSERT INTO produto (categoria_id, marca_id, ecommerce_id, nome_pro, descricao, estoque, preco, preco_antigo, promocao, novo_produto)
        //         VALUES (?,?,?,?,?,?,?,?,?,?)';
        // $sql = $this->db->prepare($sql);
        // $sql->bindValue(1, $ );
        // $sql->bindValue(2, $ );
        // $sql->bindValue(3, $ );
        // $sql->bindValue(4, $ );
        // $sql->bindValue(5, $ );
        // $sql->bindValue(6, $ );
        // $sql->bindValue(7, $ );
        // $sql->bindValue(8, $ );
        // $sql->bindValue(9, $ );
        // $sql->bindValue(10,$ );
        // $sql->execute();

        exit;

    }

}