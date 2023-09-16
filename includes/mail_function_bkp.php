<?php
require "vendor/PHPMailer/src/PHPMailer.php";
require "vendor/PHPMailer/src/OAuthTokenProvider.php";
require "vendor/PHPMailer/src/OAuth.php";
require "vendor/PHPMailer/src/SMTP.php";
require "vendor/PHPMailer/src/POP3.php";
require "vendor/PHPMailer/src/Exception.php";
require 'vendor/PHPMailer/src/autoloader.php';
function send_mail($to,$subject,$body){


    $adminemail = "apikey"; 

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    
    $mail->Host = "smtp.sendgrid.net";
    $mail->Port = "587";
    $mail->SMTPSecure = 'tls';
    // $mail->Port = "465";
    // $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth   = true;
    $mail->Username = $adminemail;
    $mail->Password = "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";
    $mail->setFrom('saisatya51@gmail.com','Dev');
    

    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->msgHTML($body);
    if (!$mail->send()) {
        print_r($mail->ErrorInfo);
        die('fail');
    }else{
    }
}


send_mail('saikiran.m.v.s.s@gmail.com','Checked','Checked');

?>