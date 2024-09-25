<?php
require 'vendor/autoload.php'; // Переконайтеся, що шлях до autoload.php правильний

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Налаштування сервера
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'marina.wellnessguru@gmail.com';
    $mail->Password   = 'ayyk azwy gqzm rzli'; // Ваш фактичний пароль
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Відправник
    $mail->setFrom('marina.wellnessguru@gmail.com', 'Wellness Guru');
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
