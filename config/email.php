<?php

return [
    'logo' => assets('storage/public/appearances/image/limahosting.png'),
  'setup' => 
  [
    'mailer' => env('MAIL_MAILER'),
    'host' => env('MAIL_HOST'),
    'port' => env('MAIL_PORT'),
    'encryption' => env('MAIL_ENCRYPTION'),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'from' => env('MAIL_FROM_ADDRESS'),
    'from_name' => env('MAIL_FROM_NAME'),
    'reply_to' => env('MAIL_REPLY_TO')
      ]
];