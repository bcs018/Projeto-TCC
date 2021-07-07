<?php 

namespace src\models\commerce;

use \core\Model;

class Produto extends Model{

    /**
     * --- PRODUTOS
     */

    // Cadastra produto
    public function cadProdutoActionFirst($nomeProd, $descProd, $categoria, $marca, $estoque, $preco, $precoAnt, $promo, $novo){
        $flag = 0;
        $preco = str_replace(',','.',$preco);
        $preco = str_replace(' ','',$preco);
        $preco = floatval($preco);

        $precoAnt = str_replace(',','.',$precoAnt);
        $precoAnt = str_replace(' ','',$precoAnt);
        $precoAnt = floatval($precoAnt);

        $promo = intval($promo);

        $_SESSION['message'] = '';
        
        if(empty($nomeProd) || empty($descProd) || empty($estoque) || empty($preco)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Existem campos não preenchidos!
                                    </div>';
            //return ['insercao'=>false];
            $flag = 1;
        }

        if(!is_numeric($estoque) || $estoque <= 0){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Estoque não numérico ou menor ou igual a ZERO!
                                    </div>';
            //return ['insercao'=>false];
            $flag = 1;
        }


        if(($promo < 0 || $promo > 1) || ($novo < 0 || $novo > 1)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Houve um problema ao adicionar o produto, atualize a página e tente novamente!
                                    </div>';
            //return ['insercao'=>false];
            $flag = 1;
        }

        // Verifica se a marca existe
        $sql = 'SELECT * FROM marca WHERE ecommerce_id = ? AND marca_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $marca);
        $sql->execute();

        if($sql->rowCount() == 0){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Marca não encontrada!
                                    </div>';
            //return ['insercao'=>false];
            $flag = 1;
        }

        // Verifica se a categoria existe
        $sql = 'SELECT * FROM categoria WHERE ecommerce_id = ? AND categoria_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $categoria);
        $sql->execute();

        if($sql->rowCount() == 0){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Categoria não encontrada!
                                    </div>';
            //return ['insercao'=>false];
            $flag = 1;
        }

        if($flag == 1)
            return ['insercao'=>false];

        $sql = 'INSERT INTO produto (categoria_id, marca_id, ecommerce_id, nome_pro, descricao, estoque, preco, preco_antigo, promocao, novo_produto)
                VALUES (?,?,?,?,?,?,?,?,?,?)';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $categoria);
        $sql->bindValue(2, $marca);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        $sql->bindValue(4, $nomeProd);
        $sql->bindValue(5, $descProd);
        $sql->bindValue(6, $estoque);
        $sql->bindValue(7, $preco);
        $sql->bindValue(8, $precoAnt);
        $sql->bindValue(9, $promo);
        $sql->bindValue(10, $novo);
        
        if($sql->execute())
            return ['insercao'=>true, 'id'=>$this->db->lastInsertId()];

        $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                    Ocorreu erro interno 001 ao inserir o produto, contate o administrador BW Commerce.
                                 </div>';
        return ['insercao'=>false];

        exit;
    }

    public function cadProdutoActionSecond($img){
        if(count($img['imagem']['tmp_name']) > 0){

            for($a=0; $a < count($img['imagem']['tmp_name']); $a++){
                $tpArq = explode('/', $img['imagem']['type'][$a]);
                if($tpArq[1] != 'jpg' || $tpArq[1] != 'jpeg' || $tpArq[1] != 'png'){
                    $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                                Formato de imagem diferente de JPG, JPEG ou PNG!
                                            </div>';
                    return false;
                }
            }

            for($i=0; $i < count($img['imagem']['tmp_name']); $i++){
                $tpArq = explode('/', $img['imagem']['type'][$i]);

                $nomeArq = $_SESSION['id_sub_dom'].md5($img['imagem']['name'][$i].rand(0,999).time()).'.'.$tpArq[1];

                move_uploaded_file($img['imagem']['tmp_name'][$i], '../assets/commerce/images_commerce/'.$nomeArq);
            }
        }
    }
}