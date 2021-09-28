<?php 

namespace src\models\commerce;

use \core\Model;

class Marca extends Model{

    /**
     * --- MARCAS
     */

    // Lista todas as marcas
    public function listaMarcas(){
        $sql = "SELECT * FROM marca WHERE ecommerce_id = ? AND ativo = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, '1');
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }
    }

    // Lista uma marca
    public function listaMarca($id){
        $sql = "SELECT * FROM marca WHERE ecommerce_id = ? AND marca_id = ? AND ativo = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $id);
        $sql->bindValue(3, '1');
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }

        return false;
    }

    // Cadastra marca
    public function cadMarca($nomeMarca){
        $sql = "INSERT INTO marca (ecommerce_id, nome_mar, ativo) VALUES (?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $nomeMarca);
        $sql->bindValue(3, '1');

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
            $sql = "UPDATE marca SET ativo = ? WHERE marca_id = ? AND ecommerce_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, '0');
            $sql->bindValue(2, $id);
            $sql->bindValue(3, $_SESSION['id_sub_dom']);
            
            if($sql->execute()){
                $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                            Marca excluida com sucesso!
                                        </div>';

                return true;
            }
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Erro 001 ao excluir marca. Verifique se a marca não está vinculada a um produto antes de exclui-la!
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

    public function addImagemMarcaAction($img, $idMarca){
        $tpArq = explode('/', $img['type']);

        if(($tpArq[1] != 'jpg') && ($tpArq[1] != 'jpeg') && ($tpArq[1] != 'png')){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Formato da imagem diferente de JPG, JPEG ou PNG!
                                    </div>';

            return false;
        }
        
        list($largura, $altura) = getimagesize($img['tmp_name']);

        if($altura < 100 || $altura > 120 || $largura < 250 || $largura > 270){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Imagem do banner não está entre 250x100 e 270x120 mega pixels!
                                    </div>';
            return false;
        }

        $sql = "SELECT * FROM marca WHERE marca_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $idMarca);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->execute();

        // Verificando se ja existe banner no produto, caso exista exclui a imagem para add a nova
        if($sql->rowCount() > 0){
            $imgMar = $sql->fetch();

            if($imgMar['marca_img'] != '0'){
                unlink('../assets/commerce/images_commerce/'.$imgMar['marca_img']);
            }
        }

        $nomeArq = 'mar'.$_SESSION['id_sub_dom'].md5($img['name'].rand(0,999).time()).'.'.$tpArq[1];
        move_uploaded_file($img['tmp_name'], '../assets/commerce/images_commerce/'.$nomeArq);

        $sql = "UPDATE marca SET marca_img = ? WHERE marca_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nomeArq);
        $sql->bindValue(2, $idMarca);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        
        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                        Imagem adicionado com sucesso!
                                    </div>';

            return true;
        }
    }

    public function excImgMarcaAction($idMarca){
        $marca = $this->listaMarca($idMarca);

        if(!$marca){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Marca não encontrada!
                                    </div>';

            return false;
        }

        unlink('../assets/commerce/images_commerce/'.$marca['marca_img']);

        $sql = "UPDATE marca SET marca_img = ? WHERE marca_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, '0');
        $sql->bindValue(2, $idMarca);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        $sql->execute();

        $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                    Imagem excluido com sucesso!
                                </div>';

        return true;
    }
}