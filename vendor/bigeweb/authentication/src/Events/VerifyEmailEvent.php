<?php

namespace Bigeweb\Authentication\Events;

use illuminate\Support\Facades\Config;
use illuminate\Support\Mail\Email\Email;
use illuminate\Support\Mail\Supports\GenerateMailAltText;

class VerifyEmailEvent
{

    public function Notification(mixed $data, $verificationLink)
    {
        $mailMessage  = file_path("vendor/bigeweb/framework/Mail/Templates/EmailVerificationMail.blade.php");

        if(file_exists($mailMessage))
        {
            ob_start();
            require $mailMessage;
            $message = ob_get_clean();
            ob_clean();
        }else{
            $message = "Hi ".$data->username.",
 Thank you for registering with us! To complete your registration, please verify your email address.
        Click the button below to verify your email:
        $verificationLink
If you did not create an account, please ignore this email.
If you have any questions or need assistance, feel free to reach out to our support team.

        The ".Config::get('app.name')." Team";
        }

        $mail = Email::Mail();
        $mail->recepient($data->email)
            ->message('Email Verification Request', $message, GenerateMailAltText::altText($message))
            ->send();
    }
}