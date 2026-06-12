<?php

namespace Bigeweb\Authentication\Events;

use illuminate\Support\Facades\Config;
use illuminate\Support\Mail\Email\Email;
use illuminate\Support\Mail\Supports\GenerateMailAltText;

class WelcomeEmailEvent
{

    public function welcome(mixed $data)
    {
        $mailMessage  = file_path("vendor/bigeweb/framework/Mail/Templates/welcomeMail.blade.php");

        if(file_exists($mailMessage))
        {
            ob_start();
           require $mailMessage;
            $message = ob_get_clean();
            ob_clean();
        }else{
            $message = "Hi ".$data->username.",

        Thank you for registering with us! We’re excited to have you on board.
        
        If you have any questions, feel free to reach out to our support team.
        
        Best Regards,
        The ".Config::get('app.name')." Team";
        }

        $mail = Email::Mail();
        $mail->recepient($data->email)
            ->message('welcome', $message, GenerateMailAltText::altText($message))
            ->send();
    }
}