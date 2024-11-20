<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendEmail{

    public function sendMail($email, $name , $title ,$message , $dynamicCon , $designType)
    {
        if($designType === 'message'){
            $designPage ='mailTemps/messageTemp.html';

        }elseif($designType === 'payment'){
            $designPage ='mailTemps/paymentTemp.html';
        }elseif($designType === 'otp'){
            $designPage ='mailTemps/otpTemp.html';
        }

        $fromEmail='';
        $fromName='';
        // Include PHPMailer dependencies
        require 'src/Exception.php';
        require 'src/PHPMailer.php';
        require 'src/SMTP.php';
        require 'mailTemp.php';

       
        $mail = new PHPMailer();

        //Server settings
        $mail->isSendmail();
        $mail->Host = '';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
        );

        //Recipients
        $mail->addCustomHeader('Date', date('r'));
        $mail->setFrom($fromEmail, $fromName);
        $mail->addReplyTo($fromEmail, $fromName);
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($email, $name);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->msgHTML(file_get_contents($designPage), __DIR__);
        $mail->AltBody = $message;
        $mail->Priority = 1; // 1 = High priority, 3 = Normal priority, 5 = Low priority

        // Attempt to send email
        if ($mail->send()) {
            return true;
        } else {
            // You can log or handle errors here
            return false;
        }
    }

}