<?php

/*
HABILITAR EL CORREO PARA PODER ENVIAR
https://accounts.google.com/DisplayUnlockCaptcha
https://myaccount.google.com/lesssecureapps?pli=1 
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Libraries/PHPMailer-master/src/Exception.php';
require 'Libraries/PHPMailer-master/src/PHPMailer.php';
require 'Libraries/PHPMailer-master/src/SMTP.php';

$email = $_POST["email"];


//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'jumpchiquimula@gmail.com';             //SMTP username
    $mail->Password   = 'chiquimulajump99898';                  //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    //Recipients
    $mail->setFrom('jumpchiquimula@gmail.com', 'Jump GT');
    $mail->addAddress('sandol1jose@gmail.com');                 //Add a recipient
    /*$mail->addAddress('ellen@example.com');                   //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');*/

    //Attachments
    /*
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name*/

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'ESTE ES EL ASUNTO';
    $mail->Body    = 'Enviado desde <b>000webhost.com</b>';
    $mail->AltBody = 'Enviado desde 000webhost.com';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
/*
    echo ini_set( 'display_errors', 1 );
    echo error_reporting( E_ALL );
    $from = "jumpchiquimula@gmail.com";
    $to = $email;
    $subject = "Checking PHP mail";
    $message = "PHP mail works just fine";
    $headers = "From:" . $from;
    if(mail($to,$subject,$message, $headers)){
        echo "The email message was sent.";
    }else{
        echo "No se envio el mensaje";
    } */   
?>