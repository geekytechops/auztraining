<?php

// Include Composer's autoloader
require 'vendor/autoload.php';

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

// Gmail SMTP configuration


// Create the Mailer


// Create an email message
$email='';
function send_mail($to,$subject,$body){
    $transport = Transport::fromDsn('smtp://saisatya51@gmail.com:ghhqvnmackjofijg@smtp.gmail.com?encryption=tls');
    $mailer = new Mailer($transport);   
    $email = (new Email())
    ->from('saisatya51@gmail.com')
    ->to($to)
    ->subject($subject)
    // ->text('This is the plain text message.')
    ->html($body);
    $mailer->send($email);
}

?>