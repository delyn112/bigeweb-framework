<?php

namespace illuminate\Support\Dotenv\Exceptions;

class FileNotFoundException
{

    public static function message($txt)
    {
        throw new \Exception($txt ?? "Request File is not found", http_response_code(404));
    }
}