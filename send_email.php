<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $recipient_email = htmlspecialchars($_POST['recipient_email']);
    $message = htmlspecialchars($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($recipient_email) && !empty($message)) {
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Substitua pelo seu provedor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'aluno01@aluno01.com'; // Substitua pelo seu email
            $mail->Password = '123456'; // Substitua pela sua senha ou app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->SMTPDebug = 0; // Desativar debug para produção

            // Destinatários
            $mail->setFrom($email, $name);
            $mail->addAddress($recipient_email);

            // Conteúdo
            $mail->isHTML(false);
            $mail->Subject = 'Nova mensagem de contato do site Placar Digital';
            $mail->Body = "Nome: $name\nEmail: $email\n\nMensagem:\n$message";

            $mail->send();
            echo "<script>alert('Mensagem enviada com sucesso!'); window.location.href='index.html';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Erro ao enviar mensagem: {$mail->ErrorInfo}'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos.'); window.location.href='index.html';</script>";
    }
} else {
    header("Location: index.html");
}
?>
