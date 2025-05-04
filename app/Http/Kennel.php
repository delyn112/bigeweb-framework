<?php

use Bigeweb\Authentication\Http\Middlewares\ResetPasswordMiddleware;
use Bigeweb\Authentication\Http\Middlewares\VerifyEmailMiddleware;

return [
    'web' => [
      'middleware' => \Bigeweb\App\Http\Middlewares\SimpleMiddleware::class,
        "forgot-password" => ResetPasswordMiddleware::class,
    ],

    'api' => [
           //
        ],

    'routeMiddleware' => [
        'Auth' => \Bigeweb\Authentication\Http\Middlewares\AuthenticateUserMiddleware::class,
        'isEmailVerified' => VerifyEmailMiddleware::class,
    ]
]

?>