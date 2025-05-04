<?php

namespace illuminate\Support\Dotenv\Exceptions;

class MissingKeyException
{

    public static function keyMissing()
    {
        throw new \Exception("Env key is missing, Please input key and try again", http_response_code(503));
    }
}