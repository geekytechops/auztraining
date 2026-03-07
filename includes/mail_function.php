<?php

// Include Composer's autoloader (works when called from auztraining or nca)
// Prefer the local includes/vendor (where Symfony Mailer lives), then fall back to project root vendor.
$autoloadPaths = [
    __DIR__ . '/vendor/autoload.php',
    __DIR__ . '/../vendor/autoload.php',
];
foreach ($autoloadPaths as $path) {
    if (file_exists($path)) {
        require_once $path;
    }
}

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

$email = '';
function send_mail($to, $subject, $body) {
    // $transport = Transport::fromDsn('smtp://auztraining@nationalcollege.edu.au:2025@Nationalcollege.edu.au@smtp.hostinger.com?encryption=ssl');
    $transport = Transport::fromDsn('smtp://noreply@nationalcollege.edu.au:Noreply@2026mail@smtp.hostinger.com?encryption=ssl');
    $mailer = new Mailer($transport);
    $email = (new Email())
        ->from('National College of Australia <noreply@nationalcollege.edu.au>')
        ->to($to)
        ->subject($subject)
        ->html($body);
    $mailer->send($email);
}

?>