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

    // Valida para que o usuario não acesso os dados de outros usuarios
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
                                        Faça login para continuar!
                                    </div>';
            return false;
        }

        return $sql->fetch();
    }

    /**
     * --- CATEGORIAS
     */

    // Lista todas as categorias
    public function listaCategorias(){
        $sql = "SELECT * FROM categoria WHERE ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }
    }

    // Cadastra categoria
    public function cadCategoria($nomeCategoria, $subCategoria){
        // Incluindo categoria se for uma categoria PAI
        if($subCategoria == 0){
            $sql = 'INSERT INTO categoria (nome_cat, ecommerce_id) VALUES (?,?)';
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $nomeCategoria);
            $sql->bindValue(2, $_SESSION['id_sub_dom']);

            if($sql->execute()){
                $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                            Categoria adicionada com sucesso!
                                        </div>';

                return true;
            }

            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Ocorreu erro 001 ao cadastrar uma categoria, recarregue a página e tente novamente!
                                    </div>';
            
            return false;
        }

        // Pesquisando para ver se a categoria filha existe
        $sql = 'SELECT * FROM categoria WHERE categoria_id = ? AND ecommerce_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $subCategoria);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->execute();

        // Se existir, insere a nova categoria
        if($sql->rowCount() > 0){
            $sql = 'INSERT INTO categoria (ecommerce_id, sub_cat, nome_cat) VALUES (?,?,?)';
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $_SESSION['id_sub_dom']);
            $sql->bindValue(2, $subCategoria);
            $sql->bindValue(3, $nomeCategoria);

            if(!$sql->execute()){
                $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                            Ocorreu erro 002 ao cadastrar uma categoria, recarregue a página e tente novamente!
                                        </div>';
                return false;
            }

            $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                        Categoria adicionada com sucesso!
                                    </div>';

            return true;
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Não foi encontrado categoria selecionada no campo Subcategoria, recarregue a página e tente novamente!
                                </div>';

        return false;

    }

    /**
     * --- MARCAS
     */

    // Lista todas as marcas
    public function listaMarcas(){
        $sql = "SELECT * FROM marca WHERE ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }
    }

    // Lista uma marca
    public function listaMarca($id){
        $sql = "SELECT * FROM marca WHERE ecommerce_id = ? AND marca_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }

        return false;
    }

    // Cadastra marca
    public function cadMarca($nomeMarca){
        $sql = "INSERT INTO marca (ecommerce_id, nome_mar) VALUES (?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $nomeMarca);

        if($sql->execute()){
            $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                        Marca adicionada com sucesso!
                                    </div>';
            return true;
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Erro ao cadastrar marca, recarregue a página e tente novamente!
                                </div>';

        return false;

    }

    // Exclui marca
    public function excMarca($id){
        $sql = "SELECT * FROM marca WHERE marca_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = "DELETE FROM marca WHERE marca_id = ? AND ecommerce_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->bindValue(2, $_SESSION['id_sub_dom']);
            
            if($sql->execute()){
                $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                            Marca excluida com sucesso!
                                        </div>';

                return true;
            }
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Erro 001 ao excluir marca, atualize a página e tente novamente!
                                </div>';

        return false;
    }

    // Edita marca
    public function ediMarca($id, $nomeMarca){
        if(!$this->listaMarca($id)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Erro 001 ao editar marca, atualize a página e tente novamente!
                                    </div>';
            return false;
        }

        $sql = "UPDATE marca SET nome_mar = ? WHERE marca_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nomeMarca);
        $sql->bindValue(2, $id);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);

        if($sql->execute()){
            $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                        Marca editada com sucesso!
                                    </div>';

            return true;
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Erro 002 ao editar marca, atualize a página e tente novamente!
                                </div>';

        return false;
    }


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