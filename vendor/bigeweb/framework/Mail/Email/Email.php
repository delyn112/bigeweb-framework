<?php

namespace illuminate\Support\Mail\Email;


use illuminate\Support\Mail\Traits\EmailTrait;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
    use EmailTrait;


    public function __construct()
    {
        $this->initializeMail();
    }

    public static function Mail()
    {
        $handler = new self();
        return $handler;
    }


    public function connection()
    {
        //Server settings
        $mail = $this->mailSource;
        $this->mailer == "smtp" ? $mail->isSMTP() : $mail->isMail();
        $mail->Host       = $this->host;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $this->username;                     //SMTP username
        $mail->Password   = $this->password;                               //SMTP password
        $mail->Port       = $this->port;
        $mail->SMTPSecure = $this->isSecure;
        $mail->SMTPKeepAlive = true;
        $mail->isSMTP();
        $mail->SMTPOptions = array(
            $this->isSecure => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->CharSet =  'utf-8';
        $mail->SMTPDebug = 0;
        return $this;
    }

    public function recepient(mixed $address)
    {
        if(is_string($address))
        {
            $addressArray = [];
            $addressArray[] = $address;
            $address = $addressArray;
        }
        $address = array($address);
        $mail = $this->mailSource;
        $mail->setFrom($this->senderEmail, $this->senderName);
        $mail->addReplyTo($this->replyTo, $this->senderName);
        foreach($address as $email)
        {
            $email_address = isset($email[0]) ? $email[0] : null;
            $name = isset($email[1]) ? $email[1] : null;
            $mail->addAddress($email_address, $name);
        }
        return $this;
    }

    public function cc(mixed $address)
    {
        if(!empty($address))
        {
            if(is_string($address))
            {
                $addressArray = [];
                $addressArray[] = $address;
                $address = $addressArray;
            }
            $address = array($address);
            $mail = $this->mailer;
            foreach($address as $email)
            {
                $email_address = isset($email[0]) ? $email[0] : null;
                $name = isset($email[1]) ? $email[1] : null;
                $mail->addCC($email_address, $name);
            }
        }
        return $this;
    }

    public function bcc(mixed $address)
    {
       if(!empty($address))
       {
           if(is_string($address))
           {
               $addressArray = [];
               $addressArray[] = $address;
               $address = $addressArray;
           }
           $address = array($address);
           $mail = $this->mailer;
           foreach($address as $email)
           {
               $email_address = isset($email[0]) ? $email[0] : null;
               $name = isset($email[1]) ? $email[1] : null;
               $mail->addBCC($email_address, $name);
           }
       }
        return $this;
    }

    public function attachmentAsString(string $path, string $name = null)
    {
        $mail =  $this->mailSource;
        $mail->addStringAttachment($path, $name);
        if($name)
        {
            $mail->addStringAttachment($path, $name);
        }
        return $this;
    }

    public function attachment(string $path, string $name = null)
    {
        $mail =  $this->mailSource;
        $mail->addAttachment($path, $name);
        if($name)
        {
            $mail->addAttachment($path, $name);
        }
        return $this;
    }

    public function message(?string $subject = null, ?string $message = null,  $altmessage = null)
    {
        $mail = $this->mailSource;
        $mail->isHTML(true);
        $mail->Subject = ''.$subject;
        $mail->Body = $message;
        $mail->AltBody = $altmessage;
        return $this;
    }

    public function send()
    {
        $this->connection();
        $this->mailSource->send();
    }
}
?>