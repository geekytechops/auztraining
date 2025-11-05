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
    $transport = Transport::fromDsn('smtp://auztraining@nationalcollege.edu.au:2025@Nationalcollege.edu.au@smtp.hostinger.com?encryption=ssl');
    $mailer = new Mailer($transport);   
    $email = (new Email())
    ->from('auztraining@nationalcollege.edu.au')
    ->to($to)
    ->subject($subject)
    // ->text('This is the plain text message.')
    ->html($body);
    $mailer->send($email);
}

?>