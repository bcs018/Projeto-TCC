<?php 

namespace src\models\commerce;

use \core\Model;

class Cadastro extends Model{

    public function cadUsuarioAction($nome, $sobrenome, $cpf, $email, $senha, $senhaRep, $cel, $login){
        $_SESSION['message'] = '';
        $flag = 0;

        if(empty($nome) || empty($sobrenome) || empty($cpf) || empty($email) || empty($senha) || empty($senhaRep) || empty($cel) || empty($login)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Existem campos em branco!
                                    </div>';

            $flag = 1;
        }
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        E-mail inválido!
                                    </div>';

            $flag = 1;
        }

        if($senha != $senhaRep){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Senhas não batem!
                                    </div>';

            $flag = 1;
        }

        if(!$this->validaCpf($cpf)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        CPF inválido!
                                    </div>';

            $flag = 1;
        }

        if(strlen($senha) < 6 || strlen($senhaRep) < 6){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Senhas menor que 6 caracteres!
                                    </div>';

            $flag = 1;
        }

        $sql = "SELECT * FROM usuario_ecommerce WHERE login_ue = ?";
        $sql = $this->db->prepare($sql);
        //$sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(1, $login);
        $sql->execute();

        if($sql->rowCount() > 0){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Já existe esse login, informe outro!
                                    </div>';

            $flag = 1;
        }

        $sql = "SELECT * FROM usuario WHERE login = ?";
        $sql = $this->db->prepare($sql);
        //$sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(1, $login);
        $sql->execute();

        if($sql->rowCount() > 0){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Já existe esse login, informe outro!
                                    </div>';

            $flag = 1;
        }

        $sql = "SELECT * FROM usuario_ecommerce ue
                JOIN eco_usu eu
                ON ue.ue_id = eu.usuario_id
                JOIN ecommerce_usu ecus
                ON ecus.ecommerce_id = eu.ecommerce_id
                WHERE ecus.ecommerce_id = ? AND ue.cpf_ue = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $cpf);
        $sql->execute();

        if($sql->rowCount() > 0){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Já existe esse CPF, informe outro!
                                    </div>';

            $flag = 1;
        }

        if($this->consultaEmail($email)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Já existe esse E-mail, informe outro!
                                    </div>';
    
            $flag = 1;
        }

        // $sql = "SELECT * FROM usuario_ecommerce ue
        //         JOIN eco_usu eu
        //         ON ue.ue_id = eu.usuario_id
        //         JOIN ecommerce_usu ecus
        //         ON ecus.ecommerce_id = eu.ecommerce_id
        //         WHERE ecus.ecommerce_id = ? AND ue.email_ue = ?";
        // $sql = $this->db->prepare($sql);
        // $sql->bindValue(1, $_SESSION['id_sub_dom']);
        // $sql->bindValue(2, $email);
        // $sql->execute();

        // if($sql->rowCount() > 0){
        //     $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
        //                                 Já existe esse E-mail, informe outro!
        //                             </div>';

        //     $flag = 1;
        // }

        if($flag == 1)return false;

        $sql = "INSERT INTO usuario_ecommerce (nome_usu_ue, sobrenome, cpf_ue, email_ue, celular_ue, login_ue, senha_ue)
                VALUES (?,?,?,?,?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nome);
        $sql->bindValue(2, $sobrenome);
        $sql->bindValue(3, $cpf);
        $sql->bindValue(4, $email);
        $sql->bindValue(5, $cel);
        $sql->bindValue(6, $login);
        $sql->bindValue(7, md5($senha));

        if($sql->execute()){
            $sql = "SELECT last_insert_id() as 'ult'";
            $idUsu = $this->db->query($sql)->fetch();

            $sql = "INSERT INTO eco_usu (ecommerce_id, usuario_id) VALUES (?,?)";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $_SESSION['id_sub_dom']);
            $sql->bindValue(2, $idUsu['ult']);

            if($sql->execute()){
                $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                            Usuário cadastrado com sucesso!
                                        </div>';
                $_SESSION['login_cliente_ecommerce'] = $idUsu;

               return true;
            }
        }

        $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                    Ocorreu erro 001, informe o administrador!
                                </div>';
        return false;

    }

    // public function loginAction($login, $senha, $control){
    //     $sql = "SELECT * FROM usuario_ecommerce ue
    //             JOIN eco_usu eu
    //             ON ue.ue_id = eu.usuario_id
    //             JOIN ecommerce_usu ecus
    //             ON ecus.ecommerce_id = eu.ecommerce_id
    //             WHERE ecus.ecommerce_id = ? AND (ue.email_ue = ? OR ue.login_ue = ?) AND ue.senha_ue = ?";
    //     $sql = $this->db->prepare($sql);
    //     $sql->bindValue(1, $_SESSION['id_sub_dom']);
    //     $sql->bindValue(2, $login);
    //     $sql->bindValue(3, $login);
    //     $sql->bindValue(4, md5($senha));
    //     $sql->execute();

    //     if($sql->rowCount() > 0){
    //         $idUsu = $sql->fetch();
    //         $_SESSION['login_cliente_ecommerce'] = $idUsu['ue_id'];

    //         // Variavel de controle para quando o usuario clicar no LOGIN entrar no painel de controle, e quando ele for fazer uma compra e nao
    //         // estiver logado, o control vai ser '' e o levara para a pagina anterior
    //         if($control == 'p'){
    //             echo json_encode(['login'=>true, 'control'=>true]);
    //             exit;
    //         }
    //         echo json_encode(['login'=>true, 'control'=>false]);
    //         exit;
    //     }
    //         echo json_encode(['login'=>false]);
    //         exit;
    // }


    
    private function validaCpf($cpf){
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    private function consultaEmail($email){
        $sql = "SELECT * FROM usuario_ecommerce WHERE email_ue = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $email);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }

        $sql = "SELECT * FROM usuario WHERE email = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $email);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }

        return false;
    }

}