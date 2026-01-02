<?php

namespace Bigeweb\Authentication\Events;

use Bigeweb\Authentication\Facades\Auth;
use illuminate\Support\Facades\Config;
use illuminate\Support\Mail\Email\Email;
use illuminate\Support\Mail\Supports\GenerateMailAltText;

class EmailVerifiedConfirmationEvent
{

    public function Notification()
    {
        $data = Auth::user();
        $mailMessage  = file_path("vendor/bigeweb/framework/Mail/Templates/EmailVerificationConfirmationMail.blade.php");

        if(file_exists($mailMessage))
        {
            ob_start();
            require $mailMessage;
            $message = ob_get_clean();
            ob_clean();
        }else{
            $message = "Hi ".$data->username.",
 Congratulations! Your email address $data->email  has been successfully verified.
        You can now enjoy all the features of your account. If you have any questions or need assistance, feel free to reach out to our support team.
        Thank you for being a part of our community!

        The ".Config::get('app.name')." Team";
        }

        $mail = Email::Mail();
        $mail->recepient($data->email)
            ->message('Email Verified Successfully', $message, GenerateMailAltText::altText($message))
            ->send();
    }
}