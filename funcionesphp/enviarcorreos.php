<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer.php';

// Bienvenida y aprobacion de usuario
function enviarcorreoUsuarios($correodestinario, $mensaje, $nombre, $apellido)
{
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
        $mail->addAddress($correodestinario, $nombre);     //Add a recipient
        //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('logo2youcitas.jpeg', 'logo.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Notificación del sistema MR';
        $mail->Body    = '
    <h1> Hola ' . $nombre . ' '.$apellido.' </h1>
    <h2>' . $mensaje . ' </h2>
    <img src="cid:logo" alt="Logotipo">
    ';
        $mail->AddEmbeddedImage('build/img/logomr.png', 'logo');
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

// Usuario Nuevo pendiente de aprobar // Hojas de trabajo nuevas
function enviarcorreoAdministrador($correodestinario, $nombre, $apellido, $fecha, $cedula, $rol)
{
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
        $mail->addAddress($correodestinario, $nombre);     //Add a recipient
        //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('logo2youcitas.jpeg', 'logo.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Notificación del sistema MR Usuario Nuevo';
        $mail->Body    = '
    <h1> Usuario Nuevo</h1>
    <h2> Se registro un usuario usuario </h2>
   
   <p> Nombre: ' . $nombre . ' '.$apellido.'</p>
   <p> Identificación: ' . $cedula . ' </p>
   <p> Perfil: ' . $rol . '</p>
   <p>  Fecha de registro: ' . $fecha . '</p>
   Por favor aprobar el registro
    <img src="cid:logo" alt="Logotipo">
    ';
        $mail->AddEmbeddedImage('build/img/logomr.png', 'logo');
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}