<?php

namespace illuminate\Support\Facades;


class Config
{
    protected static $config;


    public static function load($file)
    {
        $file = getPath().'/config/'.$file;
        if(file_exists($file))
        {
            self::$config = require $file;
        }else{
            file_put_contents('error.log', "Configuration file not found: $file");
            throw new \Exception("Configuration file not found: $file", http_response_code("404"));
        };
    }

     public static function get(string $key, $default = null)
     {
         $keys = explode(".", $key);

         if(count($keys) > 1)
         {
             $fileName = $keys[0].'.php';
             self::load($fileName);


             $value = self::$config;
             if(isset($value[$keys[1]]))
             {
                 return $value[$keys[1]];
             }
             return $default;
         }
     }
}