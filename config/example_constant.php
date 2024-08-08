<?php
if(!defined('APP_NAME'))
{
define('APP_NAME', 'Bigeweb Solution');
}

if (!defined('APP_URL')) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $domain = $_SERVER['HTTP_HOST'];
    define('APP_URL',  $protocol . $domain);
}



if(!defined('DB_CONNECTION'))
{
define('DB_CONNECTION', 'mysql');
}

if(!defined('DB_HOST'))
{
define('DB_HOST', 'localhost');
}

if(!defined('DB_PORT'))
{
define('DB_PORT', '3306');
}

if(!defined('DB_NAME'))
{
define('DB_NAME', 'pos_system');
}

if(!defined('DB_USERNAME'))
{
define('DB_USERNAME', 'root');
}

if(!defined('DB_PASSWORD'))
{
define('DB_PASSWORD', '');
}

if(!defined('APP_DEBUG'))
{
define('APP_DEBUG', 'true');
}

?>