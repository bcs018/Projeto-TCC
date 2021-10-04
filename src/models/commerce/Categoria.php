<?php 

namespace src\models\commerce;

use \core\Model;

class Categoria extends Model{
    
    // Lista a categoria selecionada e seus antecessores
    public function listaCategoriaOrganizada($id){
        $array = array();

        $haveChild = true;

        while($haveChild){
            $sql = "SELECT * FROM categoria WHERE categoria_id = ?  AND ecommerce_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $id);
            //$sql->bindValue(2, '1');
            $sql->bindValue(2, $_SESSION['id_sub_dom']);
            $sql->execute();

            if($sql->rowCount() > 0){
                $sql = $sql->fetch();
                $array[] = $sql;

                if(!empty($sql['sub_cat'])){
                    $id = $sql['sub_cat'];
                }else{
                    $haveChild = false;
                }
            }
        }

        $array = array_reverse($array);

        return $array;
    }

    // Lista todas as categorias organizadas em arvore
    public function listaCategoriasOrganizadas(){
        $array = array();

        $sql = "SELECT * FROM categoria WHERE ecommerce_id = ? AND ativo = ? ORDER BY sub_cat DESC";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, '1');
        $sql->execute();

        if($sql->rowCount() > 0){
            foreach($sql->fetchAll() as $item){
                $item['subs'] = array();
                $array[$item['categoria_id']] = $item;
            }

            while($this->organizaArray($array)){
                $this->organizaCategoria($array);
            }

        }

        return $array;
    }

    public function listaCategorias(){
        $sql = "SELECT * FROM categoria WHERE ecommerce_id = ? AND ativo = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, '1');
        $sql->execute();

        return $sql->fetchAll();
    }

    public function listaCategoria($id){
        $sql = "SELECT * FROM categoria WHERE categoria_id = ? AND ecommerce_id = ? AND ativo = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->bindValue(3, '1');
        $sql->execute();

        if($sql->rowCount() > 0)
            return $sql->fetch();

        return false;

    }

    private function organizaCategoria(&$array){
        foreach ($array as $id => $item) {
            if(isset($array[$item['sub_cat']])){
                $array[$item['sub_cat']]['subs'][$item['categoria_id']] = $item;
                unset($array[$id]);
                break;
            }
        }
    }

    private function organizaArray($array){
        foreach ($array as $item) {
            if(!empty($item['sub_cat'])){
                return true;
            }
        }

        return false;
    }

    // Cadastra categoria
    public function cadCategoria($nomeCategoria, $subCategoria){
        // Incluindo categoria se for uma categoria PAI
        if($subCategoria == 0){
            $sql = 'INSERT INTO categoria (nome_cat, ecommerce_id, ativo) VALUES (?,?,?)';
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $nomeCategoria);
            $sql->bindValue(2, $_SESSION['id_sub_dom']);
            $sql->bindValue(3, '1');

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
            $sql = 'INSERT INTO categoria (ecommerce_id, sub_cat, nome_cat, ativo) VALUES (?,?,?,?)';
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $_SESSION['id_sub_dom']);
            $sql->bindValue(2, $subCategoria);
            $sql->bindValue(3, $nomeCategoria);
            $sql->bindValue(4, '1');

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

    public function excCategoria($id){
        $sql = "SELECT * FROM categoria WHERE categoria_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = "SELECT * FROM categoria WHERE sub_cat = ? AND ecommerce_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->bindValue(2, $_SESSION['id_sub_dom']);
            $sql->execute();

            if($sql->rowCount() > 0){
                $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                            Você não pode excluir uma categoria <b>PAI</b>, exclua suas filhas primeiro e tente novamente!
                                        </div>';
                return false;

            }
    
            $sql = "UPDATE categoria SET ativo = ? WHERE categoria_id = ? AND ecommerce_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, '0');
            $sql->bindValue(2, $id);
            $sql->bindValue(3, $_SESSION['id_sub_dom']);
            
            if($sql->execute()){
                $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                            Categoria excluida com sucesso!
                                        </div>';

                return true;
            }
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Erro 001 ao excluir categoria. Verifique se a categoria não está vinculada a um produto antes de exlui-la!
                                </div>';

        return false;
    }

    public function ediCategoria($id, $nomeCategoria, $sub){
        $categoria = $this->listaCategoria($id);
        // Pegando a subcategoria para verificar se ela é categoria pai junto com a categoria a ser editada
        $subCategoria = $this->listaCategoria($sub);

        if(!$categoria){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Erro 001 ao editar categoria, atualize a página e tente novamente!
                                    </div>';
            return false;
        }

        if($categoria['sub_cat'] == null && $subCategoria['sub_cat'] == null && $this->verificaFilha($id) || 
           $this->verificaFilha($id) && $subCategoria['sub_cat'] != null){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Você não pode colocar uma categoria <b>com subcategorias</b> dentro de outra <b>categoria PAI ou subcategoria</b>
                                    </div>';
            return false;

        }

        if($sub == 0) $sub = null;

        $sql = "UPDATE categoria SET nome_cat = ?, sub_cat = ? WHERE categoria_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nomeCategoria);
        $sql->bindValue(2, $sub);
        $sql->bindValue(3, $id);
        $sql->bindValue(4, $_SESSION['id_sub_dom']);
        
        if($sql->execute()){
            $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                        Categoria editada com sucesso!
                                    </div>';

            return true;
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Erro 002 ao editar categoria, atualize a página e tente novamente!
                                </div>';

        return false;
    }

    private function verificaFilha($id){
        $sql = "SELECT * FROM categoria WHERE sub_cat = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->execute();

        if($sql->rowCount() > 0)
            return true;

        return false;

    }
}