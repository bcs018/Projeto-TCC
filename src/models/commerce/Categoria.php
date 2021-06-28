<?php 

namespace src\models\commerce;

use \core\Model;

class Categoria extends Model{
    
    /**
     * --- CATEGORIAS
     */

    // Lista todas as categorias organizadas em arvore
    public function listaCategoriasOrganizadas(){
        $array = array();

        $sql = "SELECT * FROM categoria WHERE ecommerce_id = ? ORDER BY sub_cat DESC";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
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
        $sql = "SELECT * FROM categoria WHERE ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->execute();

        return $sql->fetchAll();
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
}