<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



class APP_INTI_EMAIL{

    public static function send_email($array){

        $mail = new PHPMailer(true);
        try {
            //Server settings
            //$mail->SMTPDebug = 3;
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = SMTP_EMAIL_USERNAME;                     //SMTP username
            $mail->Password   = SMTP_EMAIL_PASSWORD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;                                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($array['sendermail'], $array['sendtosubject']);
            $mail->addAddress($array['sendtoemail'], $array['sendtosubject']);     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo($array['sendermail']);
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $array['sendtosubject'];
            $mail->Body    = $array['sendtocontent'];
            $mail->AltBody = $array['sendtocontent'];

            $mail->send();
            //echo 'Message has been sent';
            $message['code'] = 1;
            $message['status'] = 'Message sent success.';

        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $message['code'] = 0;
            $message['status'] = $mail->ErrorInfo;
        }
        echo json_encode($message);
        

    }
}
?>