<?php

namespace illuminate\Support\Routes;

use illuminate\Support\Facades\Config;

class Cors
{
    public static function handle()
    {
        header("Access-Control-Allow-Origin:".implode(',', Config::get('cors.allowed_origins'))); // Or handle as needed
        header("Access-Control-Allow-Methods:".implode(',', Config::get('cors.allowed_methods')));
        header("Access-Control-Allow-Headers: ".implode(',', Config::get('cors.allowed_headers')));

        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            // Optionally, return a 200 response to preflight requests
            http_response_code(200);
            exit;
        }
    }
}