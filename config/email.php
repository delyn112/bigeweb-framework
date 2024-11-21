<?php

return [
    /**
     *
     * Application email logo
     */
    "logo" => assets("images/New Logo Black.png"),
    "setup" => [
        "mailer" => env('MAIL_MAILER', 'smtp'),
        "host" => env('MAIL_HOST'),
        "port" => env('MAIL_PORT', 587),
        "encryption" => env('MAIL_ENCRYPTION', 'tls'),
        "username" => env('MAIL_USERNAME'),
        "password" => env('MAIL_PASSWORD'),
        "from" => env('MAIL_FROM_ADDRESS'),
        "from_name" => env('MAIL_FROM_NAME'),
        "reply_to" => env('MAIL_REPLY_TO')
    ]
];