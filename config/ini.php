<?php
/**
 * Testing PHP cookie settings and improve security.
 */

//import the config app
$configFile =  getPath()."/config/app.php";
if(!file_exists($configFile))
    {
        throw new Exception("application configuration file not found!");
    }
$config = require $configFile;
//generate list of config data array
$arrayData = [
    "memory_limit" => "4000m", // Set memory limit to 256MB
    "max_file_uploads" => "20", // Set maximum number of file uploads to 20
    "upload_max_filesize" => "2048", // Set maximum upload file size to 800MB
    "post_max_size" => "2048", // Set max post size to 800MB
    "max_execution_time" => "2048", // Set max execution time to 2000 seconds
    "allow_url_fopen" => "1", // Allow URL fopen
    "date.timezone" => $config['timezone'], // Set timezone
    "display_errors" => $config['debug'], // Enable error display (set to "0" in production)

    //cookies security
    'session.cookie_httponly' => '1',
    'session.use_strict_mode' => '1',
];

//loop through the array and set the key values
foreach(array_filter($arrayData) as $key => $value)
{
    ini_set($key, $value);
    if (!empty($_SERVER['HTTPS'])) {
        ini_set('session.cookie_secure', '1');
    }
}