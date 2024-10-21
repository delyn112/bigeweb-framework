<?php

namespace illuminate\Support\Exceptions;

use illuminate\Support\Requests\Kennel;

class EmptyDataException
{
    public static function errorMessage()
    {
        $title = "404 - not found";
        ob_start();
        require (asset('/resources/views/errors/404.blade.php'));
        $page = ob_get_clean();
        $response = new Kennel();
        return $response->handle($page, 404)->send();
    }
}