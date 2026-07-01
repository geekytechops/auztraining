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

require_once __DIR__ . '/email_log_helper.php';

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

$email = '';

if (!function_exists('send_mail')) {
    /**
     * Send HTML email via Symfony Mailer and append to crm_email_log.
     *
     * @param string $to Recipient address
     * @param string $subject
     * @param string $body HTML body
     * @param array $context Optional: email_category, st_enquiry_id, st_id, sent_by_user_id, sent_by_user_name, meta (array)
     */
    function send_mail($to, $subject, $body, array $context = array()) {
        global $connection;

        $conn = (isset($connection) && $connection instanceof mysqli) ? $connection : null;

        // Ensure PHPMailer is loaded
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            $rootAutoload = dirname(__DIR__) . '/vendor/autoload.php';
            if (file_exists($rootAutoload)) {
                require_once $rootAutoload;
            }
        }

        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            $err = "PHPMailer class is not available.";
            if ($conn) {
                crm_email_log_record($conn, $to, $subject, $body, 'failed', $err, $context);
            }
            throw new Exception($err);
        }

        /* Commented out Hostinger SMTP / Symfony Mailer configuration
        $transport = Transport::fromDsn('smtp://noreply%40nationalcollege.edu.au:Noreply%402026mail@smtp.hostinger.com:465?encryption=ssl');
        $mailer = new Mailer($transport);
        $email = (new Email())
            ->from('National College of Australia <noreply@nationalcollege.edu.au>')
            ->to($to)
            ->subject($subject)
            ->html($body);
        */

        try {
            // Zepto Mail SMTP integration using PHPMailer
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->Encoding = "base64";
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.zeptomail.com.au";
            $mail->Port = 587;
            $mail->Username = "emailapikey";
            $mail->Password = 'GkDdjPiD/lEbxVjCoNzoMYVVapYys5LqHMrkNMxSpRYs7dgJtkxOecNJkSZ+nmVK6CDGDFSdd7xx9DKC4+iLLnh9dSb5K0TuOpwzGB+edd0FvHvXUPi/9/djXEfKkfasMAxn7B8w9S9j4A==';
            $mail->SMTPSecure = 'tls';
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";
            $mail->From = "support@nationalcollege.edu.au";
            $mail->FromName = "National College of Australia";
            $mail->addAddress($to);
            $mail->Body = $body;
            $mail->Subject = $subject;

            if ($mail->send()) {
                if ($conn) {
                    crm_email_log_record($conn, $to, $subject, $body, 'sent', null, $context);
                }
            } else {
                $err = $mail->ErrorInfo;
                if ($conn) {
                    crm_email_log_record($conn, $to, $subject, $body, 'failed', $err, $context);
                }
                throw new Exception("Email send failed: " . $err);
            }
        } catch (Throwable $e) {
            if ($conn) {
                crm_email_log_record($conn, $to, $subject, $body, 'failed', $e->getMessage(), $context);
            }
            throw $e;
        }
    }
}
