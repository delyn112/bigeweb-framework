<?php

namespace illuminate\Support\Exceptions;

use illuminate\Support\Requests\Kennel;

class MethodMissingException
{

    public static function message(string $message, int $code = 404)
    {
        $message;
        log_Error($message);
        ob_start();
        require (file_path('/resources/views/errors/missing_method.blade.php'));
        $page = ob_get_clean();
        $response = new Kennel();
        return $response->handle($page, 404)->send();
    }

}