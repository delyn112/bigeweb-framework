<?php

namespace Bigeweb\Authentication\Events;

use illuminate\Support\Facades\Config;
use illuminate\Support\Mail\Email\Email;
use illuminate\Support\Mail\Supports\GenerateMailAltText;

class ResetPasswordEmailEvent
{

    public function resetNotification(mixed $data, $resetLink)
    {
        $mailMessage  = file_path("vendor/bigeweb/framework/Mail/Templates/ForgotPasswordMail.blade.php");

        if(file_exists($mailMessage))
        {
            ob_start();
            require $mailMessage;
            $message = ob_get_clean();
            ob_clean();
        }else{
            $message = "Hi ".$data->username.",
We received a request to reset your password. If you didn’t make this request, you can ignore this email.

To reset your password, please click the button below:

$resetLink
If you have any questions or need assistance, feel free to reach out to our support team.
        The ".Config::get('app.name')." Team";
        }

        $mail = Email::Mail();
        $mail->recepient($data->email)
            ->message('Password Reset Request', $message, GenerateMailAltText::altText($message))
            ->send();
    }
}