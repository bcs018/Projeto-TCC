<?php 

namespace src\models\commerce;

use \core\Model;

class Produto extends Model{


    /**
     * --- PRODUTOS
     */

    // Cadastra produto
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