<?php

namespace illuminate\Support\Facades;


class Config
{
    protected static $config = [];


    public static function load($file)
    {
        if(file_exists($file))
        {
            self::$config = array_merge(self::$config, array($file));
        }else{
            file_put_contents('error.log', "Configuration file not found: $file");
            throw new \Exception("Configuration file not found: $file", http_response_code("404"));
        }
    }

     public static function get(string $key, $default = null)
     {
         $configSearchKey = explode('.', $key);

         // Check if the key is properly formatted
         if (count($configSearchKey) <= 1) {
             file_put_contents('error.log', "Configuration key is required", FILE_APPEND);
             throw new \Exception("Configuration key is required", http_response_code("404"));
         }

         $filename = $configSearchKey[0] . '.php';
         $configKey = $configSearchKey[1];

            foreach (self::$config as $configFileKey => $configFileValue)
             {
                 // Extract the filename from the path
                $getCurrentFile = explode('/', $configFileValue);
                $CurrentFile = end($getCurrentFile);

                if($CurrentFile == $filename)
                {
                    $config = require $configFileValue;
                    // Check if the key exists in the loaded configuration
                    if(isset($configKey))
                    {
                        return $config[$configKey];
                    }
                }
             }
             return $default;
     }
}