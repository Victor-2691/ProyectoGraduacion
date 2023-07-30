<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer.php';

//Create an instance; passing `true` enables exceptions
// Instancia de la clase
$mail = new PHPMailer(true);

//    echo "<pre>";
//     var_dump($codigogeneraro);
//     echo "<pre>";

try {
    // Configurar servidor de correo
    //Server settings
    // El debug se activo con 2 y se desactiva con 0
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP 
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'sistema_mrautomotriz@outlook.com'; //username
    $mail->Password   = '!hc&r>5Ka';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;
    $mail->CharSet = 'UTF-8';                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('sistema_mrautomotriz@outlook.com', 'MRAutomotriz');
    $mail->addAddress('victor.salgado.martinez@cuc.cr', 'Victor');     //Add a recipient
    //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('logo2youcitas.jpeg', 'logo.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Notificación del sistema';
    $mail->Body    = '

    <h1>Código de verificación</h1>
    <h2>El código es :  </h2>
    <img src="cid:logo" alt="Logotipo">
    ';
    $mail->AddEmbeddedImage('build/img/Logo_correo.png', 'logo');
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

