<?php

namespace Bigeweb\Authentication\Events;

use illuminate\Support\Facades\Config;
use illuminate\Support\Mail\Email\Email;
use illuminate\Support\Mail\Supports\GenerateMailAltText;

class ResetPasswordConfirmationEmailEvent
{

    public function Notification(mixed $data)
    {
        $mailMessage  = file_path("vendor/bigeweb/framework/Mail/Templates/ResetPasswordConfirmationMail.blade.php");

        if(file_exists($mailMessage))
        {
            ob_start();
            require $mailMessage;
            $message = ob_get_clean();
            ob_clean();
        }else{
            $message = "Hi ".$data->username.",
 Your password has been changed successfully. If you didn’t make this change, please contact our support team immediately.
  Thank you for being a part of our community!

If you have any questions or need assistance, feel free to reach out to our support team.
        The ".Config::get('app.name')." Team";
        }

        $mail = Email::Mail();
        $mail->recepient($data->email)
            ->message('Your password has been changed', $message, GenerateMailAltText::altText($message))
            ->send();
    }
}