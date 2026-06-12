<?php

namespace illuminate\Support\Facades;


class Config
{
    protected static $config = [];


    public static function load(string $file)
    {
        if(file_exists($file))
        {
            self::$config = array_merge(self::$config, array($file));
        }else{
            throw new \Exception("Configuration file not found: $file", http_response_code("404"));
        }
    }

    public static function get(string $key, $default = null)
    {
        $configSearchKey = explode('.', $key);

        // Check if the key is properly formatted
        if (count($configSearchKey) < 1) {
            file_put_contents('error.log', "Configuration key is required", FILE_APPEND);
            throw new \Exception("Configuration key is required", http_response_code(404));
        }

        $filename = $configSearchKey[0] . '.php';

        // Loop through the configuration files
        foreach (self::$config as $configFileKey => $configFileValue) {
            // Extract the filename from the path
            $getCurrentFile = explode('/', $configFileValue);
            $currentFile = end($getCurrentFile);

            // Check if the current file matches the desired filename
            if ($currentFile == $filename) {
                // Load the configuration
                $config = require $configFileValue;

                // Navigate through the nested configuration using the keys
                foreach ($configSearchKey as $index => $k) {
                    // Skip the first part since it's the filename
                    if ($index === 0) {
                        continue;
                    }

                    // If the key exists, update the config to be the next level down
                    if (isset($config[$k])) {
                        $config = $config[$k];
                    } else {
                        // If the key doesn't exist, return the default value
                        return $default;
                    }
                }

                // Return the final value found in the config
                return $config;
            }
        }

        // If the configuration file was not found, return the default value
        return $default;
    }
}