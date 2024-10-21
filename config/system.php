<?php

use bigeweb\app\Http\Controllers\Controller;
use config\Session;

/**
 * @get the base path of the application
 * 
 */

function getPath()
{
   return  dirname(__DIR__);
}



/**
 * 
 * make a custome function to always include view
 */

function makeView($file, $data = [], $viewFrom = '/resources/views/' )
{
    // Extract the variables from the data array
    extract($data);

    // Include the view file
     $path = getPath().$viewFrom.$file.'.blade.php';
     include ($path);
}


function url()
{
    return $_SERVER['REQUEST_URI'];
}

function segements(int $param)
{
    $split_url = explode('/', url());
    $new_url = [];
    if(count($split_url) )
    {
        foreach ($split_url as $url)
        {
            if($url == '')
            {
                continue;
            }
            $new_url[] = $url;
        }

        if(isset($new_url[$param]))
        {
            return $new_url[$param];
        }

    }
    return null;


}

function show($data)
{
    echo ($data);
}


    function makeurl($uri)
    {
        $tempUrl = trim($uri, '/');

       $param = APP_URL.'/'.$tempUrl;
        return ($param);
    }

function asset($filepath)
{
    $checkpos = strpos('/', $filepath);

   if($checkpos == false)
   {
    $filepath = DIRECTORY_SEPARATOR.$filepath;
   }else{
    $filepath = $filepath;
   }
   $filepath = str_ireplace('/', DIRECTORY_SEPARATOR, $filepath);

 return (dirname(__DIR__).$filepath);
}


function old_value($parameter)
{
    if(!empty($_POST))
    {
        return $_POST[$parameter];
    }
}

function old_select($parameter, $value)
{
    if(!empty($_POST))
    {
       if($_POST[$parameter] == $value)
       {
        return "selected";
       }
    }
}


function checked($parameter, $value)
{
    if(!empty($_POST))
    {
       if($_POST[$parameter] == $value)
       {
        return "checked";
       }
    }
}

function redirect($url)
{
    if (str_contains($url , APP_URL))
    {
        return header("location: ".$url, true, 301);
    }


    if(strpos($url, '/'))
    {
        $url = '/'.$url;
    }else{
        $url = $url;
    }
    return header("location: ".APP_URL.$url, true, 301);
}

function redirectBack()
{
    return $_SERVER['HTTP_REFERER'];
}

function view($file, $param = [])
{
    $Controller = new Controller();
    return $Controller->view($file, $param);
};

function error($key , $param)
{
    if(!empty($key[$param]))
    {
        return ($key[$param]);
    }
}


function image($file)
{
    return makeurl($file);
}

function mask($text)
{
   return password_hash($text, PASSWORD_DEFAULT);
}

function mash_check($plain_text, $mask_text)
{
    return password_verify($plain_text, $mask_text);
}


function route(string $param, $option = [])
{
    $router = \illuminate\Support\Routes\Route::allroutes();
    $url = null;
    foreach ($router as $route) {
        $method = array_key_first($route->routes);
        if ($route->routes[$method]['name'] == $param) {
            $url = makeurl($route->routes[$method]['uri']);
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

 function pdfImage($file)
{

//    data:image/jpeg;base64,<?= base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/assets/profile-pics.jpg'))
    $encodedImage = base64_encode(file_get_contents($file));
    return( "data:image/jpeg;base64, $encodedImage");
}
?>