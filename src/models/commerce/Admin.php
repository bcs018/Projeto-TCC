<?php 

namespace src\models\commerce;

use \core\Model;

class Admin extends Model{

    // public function verificarLogin($sub, $login, $senha){
    //     $sql = "SELECT eu.ecommerce_id, eu.sub_dominio, eu.nome_fantasia, u.usuario_id, u.nome, u.cpf, u.senha FROM ecommerce_usu eu
    //             JOIN ecom_usua ecu
    //             ON ecu.ecommerce_id = eu.ecommerce_id
    //             JOIN usuario u 
    //             ON u.usuario_id = ecu.usuario_id
    //             WHERE eu.sub_dominio = ? AND u.login = ? AND u.senha = ?";
    //     $sql = $this->db->prepare($sql);
    //     $sql->bindValue(1, $sub);
    //     $sql->bindValue(2, addslashes($login));
    //     $sql->bindValue(3, md5($senha));
    //     $sql->execute();

    //     $dados = $sql->fetch();

    //     if($sql->rowCount() > 0){
    //         $_SESSION['log_admin_c']['fantasia'] = $dados['nome_fantasia'];
    //         $_SESSION['credencial'] = $login;

    //         return true;
    //     }

    //     $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
    //                                 Login e/ou Senha inválidos!
    //                             </div>';
    //     $_SESSION['credencial'] = $login;
    //     $_SESSION['log_admin_c'] = false;

    //     return false;
    // }

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
                                            Erro 001 ao editar usuário, contate o administrador PotLid Commerce!
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
                                        Erro 002 ao editar usuário, contate o administrador PotLid Commerce!
                                    </div>';
            return false;
        }

        $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                    Usuário editado com sucesso!
                                </div>';

        return true;
    }

    public function addNovoUsuAction($nome, $sobrenome, $login, $email, $celular, $cep, $rua, $bairro, $numero, $cidade, $estado, $complemento, $senha, $senhaRep){
        if(empty($nome) || empty($sobrenome) || empty($login) || empty($senha) || empty($senhaRep)){            
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                      Existe campos obrigatórios em brancos, verifique os campos e tente novamente!
                                    </div>';
            return false;
        }

        if(!empty($cep)){
            $cep = explode('-', $cep);
            $cep = intval($cep[0].$cep[1]);
        }

        if($senha != $senhaRep){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                      Senhas não batem!
                                    </div>';
            return false;
        }

        if(!empty($estado)){
            $sql = "SELECT * FROM estado WHERE estado_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $estado);
            $sql->execute();

            if($sql->rowCount() == 0){
                $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                            Estado inexistente!
                                        </div>';
                return false;
            }
        }

        $sql = "SELECT * FROM usuario WHERE login = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $login);
        $sql->execute();

        if($sql->rowCount() > 0){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Já existe esse Login, informe outro!
                                    </div>';
            return false;
        }

        $sql = "SELECT * FROM usuario_ecommerce WHERE login_ue = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $login);
        $sql->execute();

        if($sql->rowCount() > 0){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Já existe esse Login, informe outro!
                                    </div>';
            return false;
        }

        if($this->consultaEmail($email)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Já existe esse E-mail, informe outro!
                                    </div>';
            return false;
        }

        $sql = "INSERT INTO usuario (estado_id, nome, sobrenome, celular, dt_nascimento, cpf, email, rua, bairro, numero, cep, cidade, complemento, ativo, senha, login, tp_usuario)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $nome);
        $sql->bindValue(3, $sobrenome);
        $sql->bindValue(4, $celular);
        $sql->bindValue(5, "00/00/0000");
        $sql->bindValue(6, "00000000000");
        $sql->bindValue(7, $email);
        $sql->bindValue(8, $rua);
        $sql->bindValue(9, $bairro);
        $sql->bindValue(10, $numero);
        $sql->bindValue(11, $cep);
        $sql->bindValue(12, $cidade);
        $sql->bindValue(13, $complemento);
        $sql->bindValue(14, 1);
        $sql->bindValue(15, md5($senha));
        $sql->bindValue(16, $login);
        $sql->bindValue(17, 0);
        
        if($sql->execute()){
            $id_person = $this->db->query("SELECT last_insert_id() as 'ult'")->fetch();

            $sql = "INSERT INTO ecom_usua (usuario_id, ecommerce_id)
                    VALUES (?,?)";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $id_person['ult']);
            $sql->bindValue(2, $_SESSION['id_sub_dom']);

            if($sql->execute()){
                $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                            Usuário incluido com sucesso!
                                        </div>';
                return true;
            }
        }
        

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Erro 003 ao incluir um novo usuário!
                                </div>';
        return false;

    }

    public function ediNomeFantasia($nomeFant){
        if(!isset($nomeFant) || empty($nomeFant)){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Nome Fantasia em branco!
                                    </div>';
            return false;
        }

        $sql = "UPDATE ecommerce_usu SET nome_fantasia = ?
                WHERE ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nomeFant);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        
        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                        Nome Fantasia alterado com sucesso!
                                    </div>';

            $_SESSION['log_admin']['fantasia'] = $nomeFant;

            return true;
        }

        $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                    Erro 001 ao alterar o Nome Fantasia!
                                 </div>';

        return false;
    }

    public function addLogoAction($logo){
        $tpArq = explode('/', $logo['type']);

        if(($tpArq[1] != 'jpg') && ($tpArq[1] != 'jpeg') && ($tpArq[1] != 'png')){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                       Formato da imagem diferente de JPG, JPEG ou PNG!
                                    </div>';

            return false;
        }

        list($largura, $altura) = getimagesize($logo['tmp_name']);

        if($altura < 60 || $altura > 70 || $largura < 170 || $largura > 180){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Imagem do logotipo não está entre 170x60 e 180x70 mega pixels!
                                    </div>';
            return false;
        }

        if(isset($_SESSION['logo'])){
            unlink('../assets/commerce/images_commerce/'.$_SESSION['logo']);
        }

        $nomeArq = 'log'.$_SESSION['id_sub_dom'].md5($logo['name'].rand(0,999).time()).'.'.$tpArq[1];
        move_uploaded_file($logo['tmp_name'], '../assets/commerce/images_commerce/'.$nomeArq);

        $sql = "UPDATE ecommerce_usu SET logotipo = ? WHERE ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nomeArq);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        
        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                        Logotipo adicionado com sucesso!
                                    </div>';

            return true;
        }
    }

    public function addIcoAction($ico){
        $tpArq = explode('/', $ico['type']);

        if($tpArq[1] != 'x-icon'){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Formato da imagem diferente de ICO!
                                    </div>';

            return false;
        }

        if(isset($_SESSION['ico'])){
            unlink('../assets/commerce/images_commerce/'.$_SESSION['ico']);
        }

        $nomeArq = 'ico'.$_SESSION['id_sub_dom'].md5($ico['name'].rand(0,999).time()).'.ico';
        move_uploaded_file($ico['tmp_name'], '../assets/commerce/images_commerce/'.$nomeArq);

        $sql = "UPDATE ecommerce_usu SET ico = ? WHERE ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nomeArq);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        
        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                        Icone adicionado com sucesso!
                                    </div>';

            return true;
        }
    }

    public function addCorSec($cor){
        $sql = "UPDATE ecommerce_usu SET cor = ? WHERE ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $cor);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);

        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                        Cor adicionado com sucesso!
                                    </div>';

            return true;
        }
    }

    public function addCorRodape($cor){
        $sql = "UPDATE ecommerce_usu SET cor_rodape = ? WHERE ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $cor);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);

        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                        Cor do rodapé adicionado com sucesso!
                                    </div>';

            return true;
        }
    }

    public function addCorLetraRodape($cor){
        $sql = "UPDATE ecommerce_usu SET cor_letra_rodape = ? WHERE ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $cor);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);

        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                        Cor da letra do rodapé adicionado com sucesso!
                                    </div>';

            return true;
        }
    }

    public function ediLayout($layout){
        if(($layout != 'lay01') && ($layout != 'lay02')){
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Erro 005 ao editar layout!
                                    </div>';

            return false;
        }

        $sql = 'UPDATE ecommerce_usu SET layout = ?
                WHERE ecommerce_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $layout);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        
        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                       Layout alterado com sucesso!
                                    </div>';

            return true;
        }

        $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                    Erro 006 ao atualizar dados!
                                </div>';

        return false;
    }

    public function addRedeSocial($insta, $face, $linke){
        $sql = 'UPDATE ecommerce_usu SET facebook = ?, instagram = ?, linkedin = ?
                WHERE ecommerce_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, ($face=='')?'0':$face);
        $sql->bindValue(2, ($insta=='')?'0':$insta);
        $sql->bindValue(3, ($linke=='')?'0':$linke);
        $sql->bindValue(4, $_SESSION['id_sub_dom']);

        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                       Redes sociais alterado com sucesso!
                                    </div>';

            return true;
        }

        $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                    Erro 007 ao atualizar redes sociais!
                                </div>';

        return false;
    }

    public function cadDadosRecebimentoAction($pix){
        if(empty($pix)){
            
            $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                        Campos obrigátórios do PIX não preenchidos!
                                    </div>';

            return false;
        }

        // if((!empty($pkmpago) || !empty($tknmpago)) && (!empty($emailpagseguro) || !empty($tknpagseguro))/* && (!empty($cliid) || !empty($clisecre))*/){
        //     $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
        //                                 Não deve preencher campos do PagSeguro, Mercado Pago ou Gerencianet juntos <br>
        //                                 Preencha PagSeguro, Mercado Pago ou Gerencianet!
        //                             </div>';

        //     return false;
        // }

        // if(empty($pkmpago) && empty($emailpagseguro)){
        //     $tp_pgm = 'gerencianet';
        // }else if(empty($cliid) && empty($emailpagseguro)){
        //     $tp_pgm = 'mercadopago';
        // }else{
        //     $tp_pgm = 'pagseguro';
        // }

        $sql = 'UPDATE ecommerce_usu SET tp_recebimento = ?, chave_pix = ?
                WHERE ecommerce_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, 'pix');
        $sql->bindValue(2, $pix);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        
        if($sql->execute()){
            $_SESSION['message'] .= '<div class="alert alert-success" role="alert">
                                        Dados atualizados com sucesso!
                                    </div>';

            return true;
        }

        $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                    Erro 004 ao atualizar dados!
                                </div>';

        return false;
    }

    public function lista_estados(){
        $sql = "SELECT * FROM estado";
        $sql = $this->db->query($sql)->fetchAll();

        return $sql;
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

    public function listaQtdUsu(){
        $sql = 'SELECT count(*) as qtd FROM usuario_ecommerce ue
                JOIN eco_usu eu
                ON ue.ue_id = eu.usuario_id
                WHERE eu.ecommerce_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }

        return 0;
    }

    // Lista a qtd de usuarios cadastrado HOJE
    public function listaQtdUsuHoje(){
        $sql = "SELECT ue.data_cad FROM usuario_ecommerce ue
                JOIN eco_usu eu
                ON ue.ue_id = eu.usuario_id
                JOIN ecommerce_usu eue
                ON eue.ecommerce_id = eu.ecommerce_id
                WHERE eu.ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->execute();

        $qtd = 0;

        if($sql->rowCount() > 0){
            $usu = $sql->fetchAll();

            foreach($usu as $u){
                if(strtotime($u['data_cad']) == strtotime(date("Y-m-d"))){
                    $qtd++;
                }
            }
            return $qtd;
        }

        return 0;
    }

    public function relatorioVendas($data_ini, $data_fim, $plano){
        $dados['compras'] = '';
        $dados['mes']     = '';
        
        $sql = "SELECT SUM(total_compra) AS 'total', monthname(data_compra) AS 'mes', year(data_compra) AS 'ano' FROM compra
                WHERE data_compra BETWEEN ? AND ?
                AND ecommerce_id = ?
                GROUP BY MONTH(data_compra), YEAR(data_compra)
                ORDER BY YEAR(data_compra), MONTH(data_compra)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $data_ini);
        $sql->bindValue(2, $data_fim);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        $sql->execute();

        $mes = '';

        if($sql->rowCount() > 0){
            foreach($sql->fetchAll() as $per){
                $mes .= "['".$per['mes']."',".$per['ano'].'],';
                $dados['total'][] = $per['total'];
            }

            $sql = "SELECT * FROM compra c 
                    JOIN transacao_compra tc
                    ON c.compra_id = tc.compra_id
                    WHERE c.ecommerce_id = ? AND c.data_compra BETWEEN ? AND ?
                    ORDER BY YEAR(data_compra)";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $_SESSION['id_sub_dom']);
            $sql->bindValue(2, $data_ini);
            $sql->bindValue(3, $data_fim);
            $sql->execute();

            $dados['compras'] = $sql->fetchAll();
            $dados['mes']     = $mes;

            return $dados;
        }

        $dados['total'] = 0;

        $_SESSION['message'] = '<div class="alert alert-info" role="alert">
                                    Sem resultados nesse período, verifique o intervalo de datas!
                                </div>';

        return $dados;
    }
}