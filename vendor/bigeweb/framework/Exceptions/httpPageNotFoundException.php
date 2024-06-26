<?php
namespace illuminate\Support\Exceptions;

use Bigeweb\App\Http\Controllers\Controller;
use illuminate\Support\Requests\Kennel;

class httpPageNotFoundException extends Controller
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

