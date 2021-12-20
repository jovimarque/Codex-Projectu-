<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    function email($destino, $assunto, $mensagem) {
        $email = new PHPMailer();
        $email->isMail();
        $email -> isHTML();
        $email->Host = "smtp.titan.email";
        $email->SMTPAuth = "true";
        $email->SMTPSecure = "tls";
        $email->Port ="587";
        $email->Username = "contato@condexprojectu.com";
        $email->Password = "c@dex9090";
        $email->Subject = $assunto;
        $email->setFrom("contato@condexprojectu.com");
        $email->Body = $mensagem;
        $email->addAddress($destino);
        if($email->Send()){
            echo"<script>alert('Email enviado.');</script>";
        }else{
            echo "<script>alert('Falha ao enviar email.');</script>";
            echo $email -> ErrorInfo;
        }
        $email->smtpClose();
    }

?>