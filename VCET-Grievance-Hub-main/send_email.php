<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendMailNow($toEmail, $subject, $htmlBody) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // Your Gmail + APP PASSWORD
        $mail->Username = 'sahanagb00@gmail.com';
        $mail->Password = 'trrnlhdnkdkdzcfg';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender email
        $mail->setFrom('sahanagb00@gmail.com', 'sahana');

        // Recipient
        $mail->addAddress($toEmail);

        $mail->isHTML(true); // VERY IMPORTANT
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}
