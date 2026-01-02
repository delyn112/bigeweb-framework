<?php

use Bigeweb\App\Http\Controllers\Controller;
use illuminate\Support\Facades\Config;


/**
 * @return string
 * Base Path or directory of our project
 */
function getPath()
{
    return  dirname(__DIR__);
}

/**
 * @param string $text
 * @return void
 *
 * Translate words
 */
function trans(string $text, array $replace = [])
{
    $translationInstance = new \illuminate\Support\Trans();
    return $translationInstance->lang($text, $replace);
}

/**
 * @return string
 *
 * Make the storage path
 */

function storage_path(?string $path = 'storage')
{
    $path = rtrim($path, '/');
    $path = ltrim($path, '/');

    $storagePath = getPath().'/'.$path;
    if(!is_dir($storagePath))
    {
        mkdir($storagePath, '0755', true);
    }
    return $storagePath;
}

/**
 * @param string|null $file
 * @return string
 *
 */

function assets(?string $file = null)
{
    $url = rtrim(Config::get('app.url'), '/');

    if ($file === null) {
        return ''; // Return an empty string or a default asset path
    }


    $file = ltrim($file, '/'); // Remove leading slash from the file path
    return $url . '/' . $file;
}

function log_Error(?string $errorMessage): void
{
    $logPath = getPath().'/'.env('LOG_FOLDER').'/Logs';
    if(!is_dir($logPath))
    {
        mkdir($logPath, '0755', true);
    }
    $path = $logPath.'/error.log';
    $errorMessage = date('D, d M Y H:i:s').' - '.$errorMessage;
    File_put_contents($path, $errorMessage.PHP_EOL, FILE_APPEND);

}

/**
 * @param $filepath
 * @return string
 *
 */
function file_path($filepath)
{
    $file = ltrim($filepath, '/');
    $filepath = str_ireplace('/', DIRECTORY_SEPARATOR, $file);

    return (getPath().'/'.$filepath);
}

/**
 * @param $file
 * @param $data
 * @param $viewFrom
 * @return void
 *
 */


function makeView($file, array $data = [])
{
    $controllerInstance = new Controller();
    return $controllerInstance->partialView($file, $data);
}

/**
 * @return mixed
 *
 */
function url(?string $path = null)
{
    $uri = Config::get('app.url');
    if($path)
    {
        $uri = $uri.'/'.$path;
    }
    return $uri;
}


/**
 * @param string $key
 * @param $default
 * @return array|mixed|string|string[]|null
 *
 * Helps to get our variable from env file
 */

function env(string $key, mixed $default = null)
{
    return  \illuminate\Support\Dotenv\Dotenv::env($key, $default);
}



/**
 * @param $file
 * @return string
 * To return Pdf images
 */

function pdfAsset($file)
{

//    data:image/jpeg;base64,<?= base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/assets/profile-pics.jpg'))
    $encodedImage = base64_encode(file_get_contents($file));
    return( "data:image/jpeg;base64, $encodedImage");
}


/**
 * @param string $param
 * @param $option
 * @return mixed|string|null
 *
 */
function route(string $param, $option = [])
{
    $router = \illuminate\Support\Routes\Route::allroutes();
    $url = null;
    foreach ($router as $route) {
        $method = array_key_first($route->routes);
        if ($route->routes[$method]['name'] == $param) {
            $url = url($route->routes[$method]['uri']);
            if( count($option) > 0)
            {
                $urlArray = [];
                foreach ($option as $opt => $value)
                {
                    $urlArray[] = $opt.'='.$value;
                }
                $urlString = implode("&", $urlArray);
                $url = strstr($url , '?', true) . '?' . $urlString;
            }
        }
    }
    return $url;
}


/**
 * @param string|null $text
 * @return string
 *
 */
function MaskPassword(?string $text):string
{
    return password_hash($text, PASSWORD_DEFAULT);
}

/**
 * @param string|null $plain_text
 * @param string|null $mask_text
 * @return string
 *
 */
function VerifyMaskPassword(?string $plain_text, ?string $mask_text) : string
{
    return password_verify($plain_text, $mask_text);
}

/**
 * @param $key
 * @param $param
 * @return mixed|null
 *
 */
function error($key , $param)
{
    if(isset($key[$param]))
    {
        return ($key[$param]);
    }
    return null;
}

/**
 * @param $file
 * @param $param
 * @return array|string|string[]|null
 *
 */
function view($file, $param = [])
{

    $controllerInstance = new Controller();
    return $controllerInstance->view($file, $param);
};

/**
 * @param mixed $parameter
 * @return mixed|null
 *
 *
 */
function value(mixed $parameter)
{
    if(!empty($_POST))
    {
        if(isset($_POST[$parameter]))
        {
            return $_POST[$parameter];
        }
    }elseif(!empty($_GET))
    {
        if(isset($_GET[$parameter]))
        {
            return $_GET[$parameter];
        }
    }
    return null;
}

/**
 * @param string|null $parameter
 * @param mixed $value
 * @return mixed
 *
 */
function selected(?string $parameter, mixed $value):mixed
{
    if(!empty($_POST))
    {
        if(isset($_POST[$parameter]) && $_POST[$parameter] == $value)
        {
            return "selected";
        }
    }elseif(!empty($_GET))
    {
        if(isset($_GET[$parameter]) && $_GET[$parameter] == $value)
        {
            return "selected";
        }
    }

    return null;
}

/**
 * @param string|null $parameter
 * @param mixed $value
 * @return string|void
 * Get value of selected item
 */
function getSelected(?string $parameter, mixed $value)
{
    if($parameter == $value)
    {
        return "selected";
    }
}


/***
 * @param string|null $parameter
 * @param mixed $value
 * @return mixed
 *
 *
 */
function checked(?string $parameter, mixed $value):mixed
{
    if(!empty($_POST))
    {
        if(isset($_POST[$parameter]) && $_POST[$parameter] == $value)
        {
            return "checked";
        }
    }elseif(!empty($_GET))
    {
        if(isset($_GET[$parameter]) && $_GET[$parameter] == $value)
        {
            return "checked";
        }
    }

    return null;
}


/**
 * @param string|null $parameter
 * @param mixed $value
 * @return string|void
 * Get value of checked item
 */
function getChecked(?string $parameter, mixed $value)
{
    if($parameter == $value)
    {
        return "checked";
    }
}

function segements(?int $param)
{
    $split_url = explode('/', $_SERVER['REQUEST_URI']);

    if(count($split_url) > 0 && isset($split_url[$param]))
    {
        return $split_url[$param];
    }
    return null;
}