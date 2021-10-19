<?php 

namespace src\models\sitePrincipal;
use \core\Model;
use src\models\commerce\Notificacao;

class Cadastro extends Model{

    public function lista_estados(){
        $sql = "SELECT * FROM estado";
        $sql = $this->db->query($sql)->fetchAll();

        return $sql;
    }

    public function pegarItem($id){
        $sql = "SELECT * FROM usuario WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        return $sql->fetch();
    }

    public function inserir_cad($POST){
        /**
         * Validação dos dados enviado do usuário
         */
        ini_set('default_charset','UTF-8');

        $message['message']='';
        $flag = false;

        $POST['nome_usu']       = filter_var($POST['nome_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['sobrenome_usu']  = filter_var($POST['sobrenome_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['celular']        = filter_var($POST['celular'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['data_nasc']      = filter_var($POST['data_nasc'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['rua_usu']        = filter_var($POST['rua_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['bairro_usu']     = filter_var($POST['bairro_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['cidade']         = filter_var($POST['cidade'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['complemento']    = filter_var($POST['complemento'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['cep_usu']        = explode("-", $POST['cep_usu']); 
        $POST['cep_usu']        = (int)$POST['cep_usu'][0].$POST['cep_usu'][1];
        $POST['subdominio']     = strip_tags($POST['subdominio']);
        $POST['nome_fan']       = filter_var($POST['nome_fan'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['senha']          = filter_var($POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['rep_senha']      = filter_var($POST['rep_senha'], FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(!$this->validaCpf($POST['cpf_usu'])){
            $message['message'] = '<div class="alert alert-danger" role="alert">
                                    CPF inválido!
                                  </div>';
            $flag = true;
        }

        $data_nas = explode("/", $POST['data_nasc']);
        if($data_nas[0] > 31 || $data_nas[0] < 1 || $data_nas[1] < 1 || $data_nas[1] > 12 || $data_nas[2] > date("Y") || $data_nas[2] < 1910){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            Data de nascimento inválido!
                                                        </div>';
            $flag = true;
        }

        if(!filter_var($POST['estado_usu'], FILTER_VALIDATE_INT) || ($POST['estado_usu'] < 1 || $POST['estado_usu'] > 27)){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            Estado inválido!
                                                        </div>';
            $flag = true;
        }

        if(!filter_var($POST['cep_usu'], FILTER_VALIDATE_INT)){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            CEP inválido!
                                                        </div>';
            $flag = true;
        }

        if(!filter_var($POST['num_usu'], FILTER_VALIDATE_INT)){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            Número inválido!
                                                        </div>';
            $flag = true;
        }
                   
        if(!filter_var($POST['email_usu'], FILTER_VALIDATE_EMAIL)){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            E-mail inválido!
                                                        </div>';
            $flag = true;
        }

        if($this->consultaEmail($POST['email_usu'])){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            Já existe esse E-mail, informe outro!
                                                        </div>';
            $flag = true;
        }

        if(!empty($POST['cnpj'])){
            if(!$this->validarCnpj($POST['cnpj'])){
                $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                                CNPJ inválido!
                                                            </div>';
                $flag = true;
            }
        }else{
            $POST['cnpj'] = 0;
        }

        if($POST['senha'] != $POST['rep_senha']){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            Senhas não batem!
                                                        </div>';
            $flag = true;

        }

        if(strlen($POST['senha']) < 6 || strlen($POST['rep_senha']) < 6){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            Senhas menor que seis caracteres!
                                                        </div>';
            $flag = true;
        }

        if($this->consultaSub($POST['subdominio'])){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            Subdomínio já existe, informe outro!
                                                        </div>';
            $flag = true;
        }

        if(is_numeric($POST['subdominio'])){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            Subdomínio não pode ser numérico!
                                                        </div>';
            $flag = true;
        }

        if(strlen($POST['subdominio']) > 20){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            Subdomínio não pode ser maior que 20 caracteres!
                                                        </div>';
            $flag = true;

        }

        $sql = "SELECT * FROM usuario WHERE cpf = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $POST['cpf_usu']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                            CPF já existe, informe outro!
                                                        </div>';
            $flag = true;
        }

        if($this->consultaLogin($POST['login'])){
            $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                           Já existe esse Login, informe outro!
                                                        </div>';
            $flag = true;
        }

        /**
         * Fim da validação
         */

        // Se a flag for true, significa que ocorreu erro de validação então está saindo daqui retornando os erros p/ o controller
        if($flag){
            return $message;
        }

        $POST['subdominio'] = strtolower(str_replace(' ','-',trim($POST['subdominio'])));
        $POST['subdominio'] = str_replace('.','-',$POST['subdominio']);

        $not = new Notificacao;

        $sql = "INSERT INTO usuario (estado_id, nome, sobrenome, celular, dt_nascimento, cpf, email, rua, bairro, numero, cep, cidade, complemento, ativo, senha, login, tp_usuario)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $POST['estado_usu']);
        $sql->bindValue(2, $POST['nome_usu']);
        $sql->bindValue(3, $POST['sobrenome_usu']);
        $sql->bindValue(4, $POST['celular']);
        $sql->bindValue(5, $POST['data_nasc']);
        $sql->bindValue(6, $POST['cpf_usu']);
        $sql->bindValue(7, $POST['email_usu']);
        $sql->bindValue(8, $POST['rua_usu']);
        $sql->bindValue(9, $POST['bairro_usu']);
        $sql->bindValue(10, $POST['num_usu']);
        $sql->bindValue(11, $POST['cep_usu']);
        $sql->bindValue(12, $POST['cidade']);
        $sql->bindValue(13, $POST['complemento']);
        $sql->bindValue(14, 0);
        $sql->bindValue(15, md5($POST['senha']));
        $sql->bindValue(16, addslashes($POST['login']));
        $sql->bindValue(17, 1);
        $sql->execute();

        $sql = "SELECT last_insert_id() as 'ult'";
        $id_person = $this->db->query($sql)->fetch();

        $sql = "INSERT INTO ecommerce_usu (sub_dominio, nome_fantasia, cnpj, layout, data_cad)
                VALUES(?,?,?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $POST['subdominio']);
        $sql->bindValue(2, $POST['nome_fan']);
        $sql->bindValue(3, $POST['cnpj']);
        $sql->bindValue(4, 'lay01');
        $sql->bindValue(5, date("Y-m-d"));
        $sql->execute();

        $sql = "SELECT last_insert_id() as 'ult'";
        $id_commerce = $this->db->query($sql)->fetch();

        $sql = "INSERT INTO ecom_usua (usuario_id, ecommerce_id) VALUES (?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id_person['ult']);
        $sql->bindValue(2, $id_commerce['ult']);
        $sql->execute();

        $not->gravaNotificacao($id_commerce['ult'], 'Obrigado por se juntar conosco!', '');

        unset($_SESSION['login_cliente_ecommerce']);
        unset($_SESSION['logo']);
        
        $_SESSION['person']['id']   = $id_person['ult'];
        $_SESSION['person']['name'] = $POST['nome_usu'];
        $_SESSION['commerce']['id'] = $id_commerce['ult'];
    }

    public function ativarUsuario($ativo = 1){
        $sql = "UPDATE usuario SET ativo = ? WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $ativo);
        $sql->bindValue(2, $_SESSION['person']['id']);
        $sql->execute();
    }

    public function ver_cpf_cadastrado($cpf){
        $message['message']='';

        if(!$this->validaCpf($cpf)){
            $message['message'] = '<div class="alert alert-danger" role="alert">
                                    CPF inválido!
                                  </div>';
            return $message;
        }

        $sql = "SELECT * FROM usuario WHERE cpf = ? AND ativo = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $cpf);
        $sql->bindValue(2, 0);
        $sql->execute();

        if($sql->rowCount() == 0){
            $message['message'] = '<div class="alert alert-danger" role="alert">
                                        CPF não cadastrado ou você já possui uma conta ativa!
                                    </div>';
            return $message;
        }
        $id_person = $sql->fetch();

        $_SESSION['person']['id']   = $id_person['usuario_id'];
        $_SESSION['person']['name'] = $id_person['nome'];
    }

    public function consultaSub($sub){
        $sql = "SELECT * FROM ecommerce_usu WHERE sub_dominio = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $sub);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }

        return false;
    }

    public function consultaLogin($login){
        $sql = "SELECT * FROM usuario WHERE login = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $login);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }

        $sql = "SELECT * FROM usuario_ecommerce WHERE login_ue = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $login);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }

        return false;
    }

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

    private function validarCnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;	

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
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
