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
    public function cadProdutoActionFirst($nomeProd, $descProd, $categoria, $marca, $estoque, $preco, $precoAnt, $promo, $novo, $peso, $altura, $largura, $comprimento, $diametro){
        $flag = 0;
        $preco = str_replace(',','.',$preco);
        $preco = str_replace(' ','',$preco);
        $preco = floatval($preco);

        $precoAnt = str_replace(',','.',$precoAnt);
        $precoAnt = str_replace(' ','',$precoAnt);
        $precoAnt = floatval($precoAnt);

        $promo = intval($promo);

        $_SESSION['message'] = '';
        
        /**
         * Validação do cadastro de produtos de acordo com o plano do usuário
         */
        if(!$this->validaCadProduto())
            $flag = 1;

        if(empty($nomeProd) || empty($descProd) || empty($estoque) || empty($preco) || empty($peso) || empty($altura) || empty($largura) || empty($comprimento) || empty($diametro)){
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
            return ['insercao'=>false,'me'=>$_SESSION['message']];

        $sql = 'INSERT INTO produto (categoria_id, marca_id, ecommerce_id, nome_pro, descricao, estoque, preco, preco_antigo, promocao, novo_produto, peso, altura, largura, comprimento, diametro)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $categoria);
        $sql->bindValue(2, $marca);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        $sql->bindValue(4, $nomeProd);
        $sql->bindValue(5, nl2br($descProd));
        $sql->bindValue(6, $estoque);
        $sql->bindValue(7, $preco);
        $sql->bindValue(8, $precoAnt);
        $sql->bindValue(9, $promo);
        $sql->bindValue(10, $novo);
        $sql->bindValue(11, $peso);
        $sql->bindValue(12, $altura);
        $sql->bindValue(13, $largura);
        $sql->bindValue(14, $comprimento);
        $sql->bindValue(15, $diametro);
        
        if($sql->execute())
            return ['insercao'=>true, 'id'=>$this->db->lastInsertId()];

        $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                    Ocorreu erro interno 001 ao inserir o produto, contate o administrador PotLid Commerce.
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

                $nomeArq = 'pro'.$_SESSION['id_sub_dom'].md5($img['imagem']['name'][$i].rand(0,999).time()).'.'.$tpArq[1];

                move_uploaded_file($img['imagem']['tmp_name'][$i], '../assets/commerce/images_commerce/'.$nomeArq);

                $sql = 'INSERT INTO produto_imagem (produto_id, url) VALUES (?,?)';
                $sql = $this->db->prepare($sql);
                $sql->bindValue(1, $idProd);
                $sql->bindValue(2, $nomeArq);
                
                if(!$sql->execute()){
                    $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                                Ocorreu erro interno 002 ao inserir o produto, contate o administrador PotLid Commerce. 
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

    public function ediProdutoAction($nomeProd, $descProd, $categoria, $marca, $estoque, $preco, $precoAnt, $promo, $novo, $idProd, $peso, $altura, $largura, $comprimento, $diametro){
        $flag = 0;
        $preco = str_replace(',','.',$preco);
        $preco = str_replace(' ','',$preco);
        $preco = floatval($preco);

        $precoAnt = str_replace(',','.',$precoAnt);
        $precoAnt = str_replace(' ','',$precoAnt);
        $precoAnt = floatval($precoAnt);

        $promo = intval($promo);

        $_SESSION['message'] = '';
        
        if(empty($nomeProd) || empty($descProd) || empty($estoque) || empty($preco) || empty($peso) || empty($altura) || empty($largura) || empty($comprimento) || empty($diametro)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Existem campos não preenchidos!
                                    </div>';
            $flag = 1;
        }

        if(!is_numeric($estoque) || $estoque <= 0){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Estoque não numérico ou menor ou igual a ZERO!
                                    </div>';
            $flag = 1;
        }


        if(($promo < 0 || $promo > 1) || ($novo < 0 || $novo > 1)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Houve um problema ao adicionar o produto, atualize a página e tente novamente!
                                    </div>';
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
            return false;

        $sql = 'UPDATE produto SET categoria_id = ?, marca_id = ?, nome_pro = ?, descricao = ?, estoque = ?, preco = ?, preco_antigo = ?, promocao = ?, novo_produto = ?, peso = ?, altura = ?, largura = ?, comprimento = ?, diametro = ?
                WHERE produto_id = ? AND ecommerce_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $categoria);
        $sql->bindValue(2, $marca);
        $sql->bindValue(3, $nomeProd);
        $sql->bindValue(4, nl2br($descProd));
        $sql->bindValue(5, $estoque);
        $sql->bindValue(6, $preco);
        $sql->bindValue(7, $precoAnt);
        $sql->bindValue(8, $promo);
        $sql->bindValue(9, $novo);
        $sql->bindValue(10, $peso);
        $sql->bindValue(11, $altura);
        $sql->bindValue(12, $largura);
        $sql->bindValue(13, $comprimento);
        $sql->bindValue(14, $diametro);
        $sql->bindValue(15, $idProd);
        $sql->bindValue(16, $_SESSION['id_sub_dom']);
        
        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                        Produto atualizado com sucesso!
                                    </div>';
            return true;
        }
                
        $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                    Ocorreu erro interno 001 ao inserir o produto, contate o administrador PotLid Commerce.
                                </div>';
        return false;

        exit;
    }

    // -- Lista um produto com suas imagens
    public function listaProduto($id, $control=0, $ativo=1){
        $produtos = [];

        $sql = 'SELECT * FROM produto p
                LEFT JOIN produto_imagem pi
                ON pi.produto_id = p.produto_id
                JOIN marca m 
                ON m.marca_id = p.marca_id
                WHERE p.ecommerce_id = ? AND p.produto_id = ? AND p.ativo = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $id);
        $sql->bindValue(3, $ativo);
        $sql->execute();

        if($control == 1){
            $produtos = $sql->fetchAll();
            return $produtos;
        }

        if($sql->rowCount() > 0){
            $i = null;

            // Deixando sem produtos repetidos dentro do array
            foreach($sql->fetchAll() as $p){
                // Colocando o p[0] porque nao está vindo o id no primeiro array
                if($i != $p[0]){
                    $i = $p[0];
                    $produtoNovo[] = $p;
                }
            }

            return $produtoNovo;
        }

        return false;
    }

    // -- Lista todos os produtos sem as imagens
    public function listaProdutos($ativo='1'){
        $sql = 'SELECT * FROM produto WHERE ecommerce_id = ? AND ativo = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $ativo);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }

        return false;
    }

    // -- Lista todos produtos com suas imagens
    public function listaProdutosImg($order, $ativo='1'){
        $sql = "SELECT p.produto_id, p.nome_pro, p.ecommerce_id, p.preco, p.preco_antigo, p.banner_img, pi.pi_id, pi.produto_id, pi.url, m.nome_mar FROM produto p 
                LEFT JOIN produto_imagem pi
                ON pi.produto_id = p.produto_id
                JOIN marca m 
                ON m.marca_id = p.marca_id
                WHERE p.ecommerce_id =?  AND p.ativo = ? ORDER BY p.produto_id $order";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $ativo);
        //$sql->bindValue(2, $order);
        $sql->execute();

        if($sql->rowCount() > 0){
            $produtos = $sql->fetchAll();
            $produtosNovo = array();
            $i = null;

            foreach($produtos as $p){
                // Colocando o p[0] porque nao está vindo o id no primeiro array
                if($i != $p[0]){
                    $i = $p[0];
                    $produtosNovo[] = $p;
                }
            }

            return $produtosNovo;
        }

        $_SESSION['message'] .= '<div class="alert alert-info" role="alert">
                                    Não há produtos cadastrados nessa loja
                                </div>';
        return false;
    }

    // Lista produtos referenciados pela categoria
    public function listaProdutosRelacionados($idCat, $ativo='1'){        
        $cat = new Categoria;
        $categorias = $cat->listaCategoriaOrganizada($idCat);

        // Pegando todos os produtos cuja categoria se enquadra na categoria vinda do parametro
        foreach ($categorias as $c) {
            $sql = "SELECT * FROM produto p
                    LEFT JOIN produto_imagem pi
                    ON pi.produto_id = p.produto_id
                    JOIN marca m 
                    ON m.marca_id = p.marca_id
                    WHERE p.categoria_id = ? AND p.ecommerce_id = ? AND p.ativo = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $c['categoria_id']);
            $sql->bindValue(2, $_SESSION['id_sub_dom']);
            $sql->bindValue(3, $ativo);
            $sql->execute();

            if($sql->rowCount() > 0){
                $produtosRel = $sql->fetchAll();
            }else{
                $_SESSION['message'] = '<div class="alert alert-info" role="alert">
                                            Não há produtos nessa categoria!
                                        </div>';
                return false;
            }
        }
        // echo '---------rel original';
        // echo '<pre>';
        // print_r($produtosRel);


        // Arrumando o array pois estava ficando com 3 array um dentro do outro e o certo é ficar somente 2 arrays
        // for($i=0; $i<count($produtosRel); $i++){
        //     $prodRelNovo[] = $produtosRel[$i][0];
        // }
        
        $i = null;

        // echo '---------rel novo';
        // echo '<pre>';
        // print_r($prodRelNovo);

        //$produtosRel2 = array();

        // Deixando sem produtos repetidos dentro do array
        foreach($produtosRel as $pr){
            // Colocando o p[0] porque nao está vindo o id no primeiro array
            if($i != $pr[0]){
                $i = $pr[0];
                $produtosRel2[] = $pr;
            }
        }
        // echo '---------rel return';
        // echo '<pre>';
        // print_r($produtosRel2);exit;


        return $produtosRel2;
    }


    public function excImagem($idImg, $idProd){
        $sql = "SELECT * FROM produto p
                LEFT JOIN produto_imagem pi
                ON pi.produto_id = p.produto_id
                WHERE p.ecommerce_id = ? AND p.produto_id = ? AND pi.pi_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $idProd);
        $sql->bindValue(3, $idImg);
        $sql->execute();

        if($sql->rowCount() == 0){
            $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                        Ocorreu erro interno 002 ao apagar uma imagem, contate o administrador PotLid Commerce.
                                    </div>';
            return false;
        }

        $img = $sql->fetch();

        unlink('../assets/commerce/images_commerce/'.$img['url']);

        $sql = "DELETE FROM produto_imagem WHERE pi_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $idImg);
        $sql->execute();

        $_SESSION['message'] = '<br><div class="alert alert-success" role="alert">
                                    Imagem excluida com sucesso!
                                </div>';

        return true;
    }

    public function excBanner($id){
        $sql = "SELECT * FROM produto WHERE produto_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->execute();

        $banner = $sql->fetch();
        
        $sql = "UPDATE produto SET banner_img = ? WHERE produto_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, '0');
        $sql->bindValue(2, $id);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        $sql->execute();

        unlink('../assets/commerce/images_commerce/'.$banner['banner_img']);

        $_SESSION['message'] = '<br><div class="alert alert-success" role="alert">
                                    Banner excluido com sucesso!
                                </div>';

        return true;
    }

    public function excProduto($id){
        $sql = "SELECT * FROM produto p
                LEFT JOIN produto_imagem pi
                ON pi.produto_id = p.produto_id
                WHERE p.ecommerce_id = ? AND p.produto_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $id);
        $sql->execute();

        if($sql->rowCount() == 0){
            $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                        Ocorreu erro interno 003 ao excluir um produto, contate o administrador PotLid Commerce.
                                    </div>';
            return false;
        }

        $produtos = $sql->fetchAll();

        foreach($produtos as $img){
            if($img['url'] != null || !empty($img['url']))
                unlink('../assets/commerce/images_commerce/'.$img['url']);
        }
        
        if($produtos[0]['banner_img'] != '0')
            unlink('../assets/commerce/images_commerce/'.$produtos[0]['banner_img']);
        
        $sql = "DELETE FROM produto_imagem WHERE produto_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        $sql = "UPDATE produto SET ativo = ? WHERE produto_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, '0');
        $sql->bindValue(2, $id);
        $sql->execute();

        $_SESSION['message'] = '<br><div class="alert alert-success" role="alert">
                                    Produto excluido com sucesso!
                                </div>';

        return true;

    }

    public function addBannerProdAction($banner, $idProd){
        $tpArq = explode('/', $banner['type']);

        if(($tpArq[1] != 'jpg') && ($tpArq[1] != 'jpeg') && ($tpArq[1] != 'png')){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Formato da imagem diferente de JPG, JPEG ou PNG!
                                    </div>';

            return false;
        }
        
        list($largura, $altura) = getimagesize($banner['tmp_name']);

        if($altura < 350 || $altura > 399 || $largura < 1160 || $largura > 1163){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Imagem do banner não está entre 1160x350 e 1163x399 mega pixels!
                                    </div>';
            return false;
        }

        $sql = "SELECT * FROM produto WHERE produto_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $idProd);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->execute();

        // Verificando se ja existe banner no produto, caso exista exclui a imagem para add a nova
        if($sql->rowCount() > 0){
            $prodBan = $sql->fetch();

            if($prodBan['banner_img'] != '0'){
                unlink('../assets/commerce/images_commerce/'.$prodBan['banner_img']);
            }
        }

        $nomeArq = 'ban'.$_SESSION['id_sub_dom'].md5($banner['name'].rand(0,999).time()).'.'.$tpArq[1];
        move_uploaded_file($banner['tmp_name'], '../assets/commerce/images_commerce/'.$nomeArq);

        $sql = "UPDATE produto SET banner_img = ? WHERE produto_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nomeArq);
        $sql->bindValue(2, $idProd);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        
        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                        Banner adicionado com sucesso!
                                    </div>';

            return true;
        }

    }

    public function ediEstoque($id, $estoque){
        $sql = 'UPDATE produto SET estoque = ?
                WHERE produto_id = ? AND ecommerce_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $estoque);
        $sql->bindValue(2, $id);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        $sql->execute();

        return true;
    }

    // Valida o limite de qtd de produto para cadastro de acordo com o plano escolhido
    private function validaCadProduto(){
        $sql = 'SELECT count(*) AS qtd FROM produto
                WHERE ecommerce_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->execute();

        $qtd = $sql->fetch();

        $info = new Info;
        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        if($dados['plano_id'] == '1'){
            if($qtd['qtd'] >= 5){
                $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                            Você já atingiu o limite de produtos cadastrados
                                            de acordo com seu plano. Seu limite é de 5 produtos.<br>
                                            Exclua outros produtos ou faça upgrade de seu plano.
                                        </div>';
                
                return false;
            }
        }else if($dados['plano_id'] == '2'){
            if($qtd['qtd'] >= 15){
                $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                            Você já atingiu o limite de produtos cadastrados
                                            de acordo com seu plano. Seu limite é de 15 produtos. <br>
                                            Exclua outros produtos ou faça upgrade de seu plano.
                                        </div>';

                return false;
            }
        }else{
            return true;
        }      
        
        return true;
    }
}