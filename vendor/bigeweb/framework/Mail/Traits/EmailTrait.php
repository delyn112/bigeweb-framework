<?php

namespace illuminate\Support\Mail\Traits;


use illuminate\Support\Facades\Config;
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
        $this->mailer = Config::get('email.setup.mailer');
        $this->host = Config::get('email.setup.host');
        $this->port = Config::get('email.setup.port');
        $this->username = Config::get('email.setup.username');
        $this->password = Config::get('email.setup.password');
        $this->senderName = Config::get('email.setup.from_name');
        $this->senderEmail = Config::get('email.setup.from');
        $this->isSecure = Config::get('email.setup.encryption');
        $this->replyTo = Config::get('email.setup.reply_to');
        $this->mailSource = new PHPMailer(true);
    }
}