<?php 

namespace src\models;
use \core\Model;

class Cadastro extends Model{

    public function lista_estados(){
        $sql = "SELECT * FROM estado";
        $sql = $this->db->query($sql)->fetchAll();

        return $sql;
    }

    public function inserir_cad($POST){
        /**
         * Validação dos dados enviado do usuário
         */
        $message['message']='';
        $flag = false;

        $POST['nome_usu']       = filter_var($POST['nome_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['sobrenome_usu']  = filter_var($POST['sobrenome_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['celular']        = filter_var($POST['celular'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['data_nasc']      = filter_var($POST['data_nasc'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['rua_usu']        = filter_var($POST['rua_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['bairro_usu']     = filter_var($POST['bairro_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['cep_usu']        = explode("-", $POST['cep_usu']); 
        $POST['cep_usu']        = $POST['cep_usu'][0].$POST['cep_usu'][1];
        $POST['subdominio']     = strip_tags($POST['subdominio']);
        $POST['nome_fan']       = filter_var($POST['nome_fan'], FILTER_SANITIZE_SPECIAL_CHARS);
        
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

        if(!empty($POST['cnpj'])){
            if(!$this->validarCnpj($POST['cnpj'])){
                $message['message'] =  $message['message'].'<div class="alert alert-danger" role="alert">
                                                                CNPJ inválido!
                                                            </div>';
                $flag = true;
            }
        }

        /**
         * Fim da validação
         */

        // Se a flag for true, significa que ocorreu erro de validação então está saindo daqui retornando os erros p/ o controller
        if($flag){
            return $message;
        }

        $sql = "INSERT INTO usuario (estado_id, nome, sobrenome, celular, dt_nascimento, cpf, email, rua, bairro, numero, cep)
                VALUES (?,?,?,?,?,?,?,?,?,?,?)";
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
        $sql->execute();
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

}
