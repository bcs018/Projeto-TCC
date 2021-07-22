<?php 

namespace src\models\commerce;

use \core\Model;

class Admin extends Model{

    public function verificarLogin($sub, $login, $senha){
        $sql = "SELECT eu.ecommerce_id, eu.sub_dominio, eu.nome_fantasia, u.usuario_id, u.nome, u.cpf, u.senha FROM ecommerce_usu eu
                JOIN ecom_usua ecu
                ON ecu.ecommerce_id = eu.ecommerce_id
                JOIN usuario u 
                ON u.usuario_id = ecu.usuario_id
                WHERE eu.sub_dominio = ? AND u.login = ? AND u.senha = ?";
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
                                    Login e/ou Senha inválidos!
                                </div>';
        $_SESSION['credencial'] = $login;
        $_SESSION['log_admin_c'] = false;

        return false;
    }

    // Valida para que o usuario não acesso os dados de outros usuarios
    public function listaDados($sub){
        $sql = "SELECT * FROM ecommerce_usu eu
                JOIN ecom_usua ecu
                ON eu.ecommerce_id = ecu.ecommerce_id
                JOIN usuario u 
                ON u.usuario_id = ecu.usuario_id
                WHERE eu.sub_dominio = ? AND u.login = ?";
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

    public function ediDadosPessoaisAction($idUsu, $nome, $sobrenome, $celular, $cep, $rua, $bairro, $numero, $cidade, $estado, $complemento='0', $senha, $senhaRep){
        $_SESSION['message'] = '';
        $flag = 0;

        if(!isset($nome) || empty($nome) || !isset($sobrenome) || empty($sobrenome)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Nome ou Sobrenome em branco!
                                    </div>';
            $flag = 1;
        }

        if(!isset($celular) || empty($celular)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Celular em branco!
                                    </div>';
            $flag = 1;
        }

        if(!isset($cep) || empty($cep) || !isset($rua) || empty($rua) || !isset($bairro) || empty($bairro) || !isset($numero) || empty($numero) || !isset($cidade) || empty($cidade) || !isset($estado) || empty($estado) ){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        CEP, Rua, Bairro, Número, Cidade ou Estado em branco!
                                    </div>';
            $flag = 1;
        }

        if($flag == 1)
            return false;
        
        unset($_SESSION['message']);
        
        if(!empty($senha) && !empty($senhaRep)){
            if($senha != $senhaRep){
                $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                            Senhas não batem!
                                        </div>';
                return false;
            }

            $sql = "SELECT * FROM ecommerce_usu eu
                    JOIN ecom_usua ecu
                    ON eu.ecommerce_id = ecu.ecommerce_id
                    JOIN usuario u 
                    ON u.usuario_id = ecu.usuario_id
                    WHERE u.usuario_id = ? AND eu.ecommerce_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $idUsu);
            $sql->bindValue(2, $_SESSION['id_sub_dom']);
            $sql->execute();

            if($sql->rowCount() == 0){
                $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                            Sem permissão para editar esse usuário!
                                        </div>';
                return false;
            }

            $sql = "UPDATE usuario SET estado_id = ?, nome = ?, sobrenome = ?, celular = ?, rua = ?, bairro = ?, numero = ?, cep = ?, cidade = ?, complemento = ?, ativo = ?, senha = ?
                    WHERE usuario_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $estado);
            $sql->bindValue(2, $nome);
            $sql->bindValue(3, $sobrenome);
            $sql->bindValue(4, $celular);
            $sql->bindValue(5, $rua);
            $sql->bindValue(6, $bairro);
            $sql->bindValue(7, $numero);
            $sql->bindValue(8, $cep);
            $sql->bindValue(9, $cidade);
            $sql->bindValue(10, $complemento);
            $sql->bindValue(11, 1);
            $sql->bindValue(12, md5($senha));
            $sql->bindValue(13, $idUsu);

            if(!$sql->execute()){
                $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                            Erro 001 ao editar usuário, contate o administrador BW Commerce!
                                        </div>';
                return false;
            }

            $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                        Usuário editado com sucesso!
                                    </div>';

            return true;
        }

        $sql = "SELECT * FROM ecommerce_usu eu
                JOIN ecom_usua ecu
                ON eu.ecommerce_id = ecu.ecommerce_id
                JOIN usuario u 
                ON u.usuario_id = ecu.usuario_id
                WHERE u.usuario_id = ? AND eu.ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $idUsu);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->execute();

        if($sql->rowCount() == 0){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Sem permissão para editar esse usuário!
                                    </div>';
            return false;
        }

        $sql = "UPDATE usuario SET estado_id = ?, nome = ?, sobrenome = ?, celular = ?, rua = ?, bairro = ?, numero = ?, cep = ?, cidade = ?, complemento = ?, ativo = ?
                WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $nome);
        $sql->bindValue(3, $sobrenome);
        $sql->bindValue(4, $celular);
        $sql->bindValue(5, $rua);
        $sql->bindValue(6, $bairro);
        $sql->bindValue(7, $numero);
        $sql->bindValue(8, $cep);
        $sql->bindValue(9, $cidade);
        $sql->bindValue(10, $complemento);
        $sql->bindValue(11, 1);
        $sql->bindValue(12, $idUsu);

        if(!$sql->execute()){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Erro 001 ao editar usuário, contate o administrador BW Commerce!
                                    </div>';
            return false;
        }

        $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                    Usuário editado com sucesso!
                                </div>';

        return true;
    }

    public function lista_estados(){
        $sql = "SELECT * FROM estado";
        $sql = $this->db->query($sql)->fetchAll();

        return $sql;
    }
}