<?php

namespace illuminate\Support\Supports;


use Base\Project\Configurations\Email\src\models\Email_Setting;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
    private $mailer;
    protected $emailConfig;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $model = new Email_Setting();
        $this->emailConfig = $model->first();

    }

    public static function Mail()
    {
        $handler = new self();
        return $handler;
    }


    public function connection()
    {
        //Server settings
        $mail = $this->mailer;
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $this->emailConfig->host;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $this->emailConfig->username;                     //SMTP username
        $mail->Password   = $this->emailConfig->password;                               //SMTP password
        $mail->Port       = $this->emailConfig->port;
        $mail->SMTPSecure = $this->emailConfig->encryption;
        $mail->SMTPKeepAlive = true;
        $mail->isSMTP();
        $mail->SMTPOptions = array(
            $this->emailConfig->encryption => array(
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
        $mail = $this->mailer;
        $mail->setFrom($this->emailConfig->email_from, $this->emailConfig->sender_name);
        $mail->addReplyTo($this->emailConfig->reply_to, $this->emailConfig->sender_name);
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
        $mail =  $this->mailer;
        $mail->addStringAttachment($path, $name);
        if($name)
        {
            $mail->addStringAttachment($path, $name);
        }
        return $this;
    }

    public function attachment(string $path, string $name = null)
    {
        $mail =  $this->mailer;
        $mail->addAttachment($path, $name);
        if($name)
        {
            $mail->addAttachment($path, $name);
        }
        return $this;
    }

    public function message($subject = null, $message = null, $altmessage = null)
    {
        $mail = $this->mailer;
        $mail->isHTML(true);
        $mail->Subject = ''.$subject;
        $mail->Body = $message;
        $mail->AltBody = $altmessage;
        return $this;
    }

    public function send()
    {
        $this->connection();
        $this->mailer->send();
    }
}
?>