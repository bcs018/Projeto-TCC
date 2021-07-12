<?php 

namespace src\models\commerce;

use \core\Model;
use \src\models\commerce\Marca;
use \src\models\commerce\Categoria;

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
        $verMarca = new Marca;

        if(!$verMarca->listaMarca($marca)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Marca não encontrada!
                                    </div>';
            $flag = 1;
        }

        // Verifica se a categoria existe
        $verCate = new Categoria;

        if(!$verCate->listaCategoria($categoria)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Categoria não encontrada!
                                    </div>';
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

    public function cadProdutoActionSecond($img, $idProd){
        if(count($img['imagem']['tmp_name']) > 0){

            for($a=0; $a < count($img['imagem']['tmp_name']); $a++){
                $tpArq = explode('/', $img['imagem']['type'][$a]);
                if(($tpArq[1] != 'jpg') && ($tpArq[1] != 'jpeg') && ($tpArq[1] != 'png')){
                    $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                                Formato da imagem diferente de JPG, JPEG ou PNG!
                                            </div>';

                    return false;
                }
            }

            for($i=0; $i < count($img['imagem']['tmp_name']); $i++){
                $tpArq = explode('/', $img['imagem']['type'][$i]);

                $nomeArq = $_SESSION['id_sub_dom'].md5($img['imagem']['name'][$i].rand(0,999).time()).'.'.$tpArq[1];

                move_uploaded_file($img['imagem']['tmp_name'][$i], '../assets/commerce/images_commerce/'.$nomeArq);

                $sql = 'INSERT INTO produto_imagem (produto_id, url) VALUES (?,?)';
                $sql = $this->db->prepare($sql);
                $sql->bindValue(1, $idProd);
                $sql->bindValue(2, $nomeArq);
                
                if(!$sql->execute()){
                    $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                                Ocorreu erro interno 002 ao inserir o produto, contate o administrador BW Commerce. 
                                            </div>';
                    return false;
                }
            }

            $_SESSION['message'] = '<br><div class="alert alert-success" role="alert">
                                        Produto inserido com sucesso!
                                    </div>';
            return true;
        }
    }

    public function ediProdutoAction($nomeProd, $descProd, $categoria, $marca, $estoque, $preco, $precoAnt, $promo, $novo, $idProd){
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
        $verMarca = new Marca;

        if(!$verMarca->listaMarca($marca)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Marca não encontrada!
                                    </div>';
            $flag = 1;
        }

        // Verifica se a categoria existe
        $verCate = new Categoria;

        if(!$verCate->listaCategoria($categoria)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Categoria não encontrada!
                                    </div>';
            $flag = 1;
        }

        if($flag == 1)
            return ['insercao'=>false];

            $sql = 'UPDATE produto SET categoria_id = ?, marca_id = ?, nome_pro = ?, descricao = ?, estoque = ?, preco = ?, preco_antigo = ?, promocao = ?, novo_produto = ?
                    WHERE produto_id = ? AND ecommerce_id = ?';
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $categoria);
            $sql->bindValue(2, $marca);
            $sql->bindValue(3, $nomeProd);
            $sql->bindValue(4, $descProd);
            $sql->bindValue(5, $estoque);
            $sql->bindValue(6, $preco);
            $sql->bindValue(7, $precoAnt);
            $sql->bindValue(8, $promo);
            $sql->bindValue(9, $novo);
            $sql->bindValue(10, $idProd);
            $sql->bindValue(11, $_SESSION['id_sub_dom']);
            
            if($sql->execute())
                return ['insercao'=>true];

            $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                        Ocorreu erro interno 001 ao inserir o produto, contate o administrador BW Commerce.
                                    </div>';
            return ['insercao'=>false];

            exit;
    }

    public function listaProduto($id){
        $sql = 'SELECT * FROM produto p
                LEFT JOIN produto_imagem pi
                ON pi.produto_id = p.produto_id
                WHERE p.ecommerce_id = ? AND p.produto_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }

        return false;
    }

    public function listaProdutos(){
        $sql = 'SELECT * FROM produto WHERE ecommerce_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }

        return false;
    }

    public function listaProdutosImg($id){
        $sql = 'SELECT p.produto_id, p.nome_pro, p.ecommerce_id, pi.pi_id, pi.produto_id, pi.url FROM produto p 
                JOIN produto_imagem pi
                ON pi.produto_id = p.produto_id
                WHERE p.ecommerce_id = ? AND p.produto_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchaAll();
        }

        return false;
    }

    /** 
     * LISTAR IMAGENS DO PRODUTO
     * 
     * select p.produto_id, p.nome_pro, p.ecommerce_id, pi.pi_id, pi.produto_id, pi.url from produto p 
     * join produto_imagem pi
     * on pi.produto_id = p.produto_id
     * where p.ecommerce_id = 1;
     */
}