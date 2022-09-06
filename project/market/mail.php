<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once './vendor/autoload.php' ;


class Mail {
    public static function send($to, $subject, $message) {

    $mail = new PHPMailer(true) ;
    try {

        $mail->SMTPDebug = 2;									
        $mail->isSMTP();											
        $mail->Host	 = 'asmtp.bilkent.edu.tr';					
        $mail->SMTPAuth = true;							
        $mail->Username = 'nurjemal.saryyeva@ug.bilkent.edu.tr';				
        $mail->Password = '***';				
        $mail->SMTPSecure = 'starttls';							
        $mail->Port	 = 587;
        
        $mail->setFrom('nurjemal.saryyeva@ug.bilkent.edu.tr', 'VERIFICATION__CODE');		
        $mail->addAddress($to);
        $mail->addAddress('nurjemal.saryyeva@ug.bilkent.edu.tr');

        $mail->isHTML(true);								
        $mail->Subject = $subject;   // 'Authenticate your account';
        $mail->Body =  $message; // 'Dear user,<br> Vefification Code is  <b>' . $code . '</b> to authenticate your account.<br><br>Best wishes,<br>CTIS256 Project&trade;.';

        $mail->send();
        echo "Mail has been sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
   }
}


