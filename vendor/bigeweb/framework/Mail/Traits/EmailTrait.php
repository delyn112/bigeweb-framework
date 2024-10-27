<?php

namespace illuminate\Support\Mail\Traits;


use PHPMailer\PHPMailer\PHPMailer;

trait EmailTrait
{

    protected $mailer;
    protected $host;
    protected $port;
    protected $username;
    protected $password;
    protected $senderName;
    protected $senderEmail;
    protected $isSecure;
    protected $mailSource;
    protected $replyTo;


    protected function initializeMail()
    {
        $this->mailer = env('MAIL_MAILER', 'smtp');
        $this->host = env('MAIL_HOST');
        $this->port = env('MAIL_PORT');
        $this->username = env('MAIL_USERNAME');
        $this->password = env('MAIL_PASSWORD');
        $this->senderName = env('MAIL_FROM_NAME');
        $this->senderEmail = env('MAIL_FROM_ADDRESS');
        $this->isSecure = env('MAIL_ENCRYPTION');
        $this->replyTo = env('MAIL_REPLY_TO');
        $this->mailSource = new PHPMailer(true);
    }
}