<?php 
namespace src\models\sitePrincipal;

use \core\Model;
use PHPMailer\PHPMailer\PHPMailer;

class Email extends Model{
    public function enviarEmail($nomeEcommerce='PotLid', $emailDestino, $titulo, $msg){
        ini_set('default_charset','UTF-8');

        $mail = new PHPMailer;
        //$mail->CharSet = 'utf-8';
        $mail->Encoding = 'base64';
        $mail->isSMTP();
        //$mail->SMTPDebug = 2;
        $mail->Host = 'mail.potlid.com.br';
        $mail->Port = 587;
        
        /*  */

        $mail->Username = 'sac@potlid.com.br';
        $mail->Password = 'b321r99uNO111';
        $mail->setFrom('sac@potlid.com.br',  utf8_decode($nomeEcommerce).' Commerce');
        $mail->addReplyTo('sac@potlid.com.br',  utf8_decode($nomeEcommerce).' Commerce');
        $mail->addAddress($emailDestino); // Para quem recebera o email
        $mail->isHTML(true);
        $mail->Subject =  utf8_decode($titulo);
        //$mail->msgHTML(file_get_contents('message.html'), __DIR__);
        $mail->Body = utf8_decode($msg);
        //$mail->addAttachment('test.txt');
        $mail->send();
    
    }
}