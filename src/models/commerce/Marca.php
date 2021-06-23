<?php 

namespace src\models\commerce;

use \core\Model;

class Marca extends Model{

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
}