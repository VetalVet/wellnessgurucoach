<?php
require 'vendor/autoload.php'; // Переконайтеся, що шлях до autoload.php правильний

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Увімкнення налагодження
    $mail->SMTPDebug = 2; // 0 = off (for production use), 1 = client messages, 2 = client and server messages

    // Налаштування сервера
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Змініть на SMTP-сервер вашого провайдера
    $mail->SMTPAuth   = true;
    $mail->Username   = 'marina.wellnessguru@gmail.com'; // Ваш логін для SMTP
    $mail->Password   = 'ayyk azwy gqzm rzli'; // Ваш пароль для SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587; // Змініть на порт вашого провайдера

    // Відправник
    $mail->setFrom('marina.wellnessguru@gmail.com', 'Your Name');
    // Отримувач
    $mail->addAddress('leveugene@gmail.com'); // Вставте фактичну адресу отримувача

    // Вміст електронного листа
    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body    = 'This is a test email sent using PHPMailer.';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
