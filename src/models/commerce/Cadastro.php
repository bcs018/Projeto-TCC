<?php 

namespace src\models\commerce;

use \core\Model;

class Cadastro extends Model{

    public function cadUsuarioAction($nome, $sobrenome, $cpf, $email, $senha, $senhaRep){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        E-mail inválido!
                                    </div>';

            return false;
        }

        if($senha != $senhaRep){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Senhas não batem!
                                    </div>';

            return false;
        }

        if(!$this->validaCpf($cpf)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        CPF inválido!
                                    </div>';

            return false;
        }
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

}