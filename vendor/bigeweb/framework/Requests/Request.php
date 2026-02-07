<?php

namespace illuminate\Support\Requests;
use illuminate\Support\Facades\Config;
use illuminate\Support\Routes\Router;



Class Request
{


    public function __construct()
    {
    }

    /**
     * 
     * Request all the post or get item from server
     * This function return all the server request
     */
    public function all()
    {

        $body = [];
        $method = strtolower(Router::method());
        $content_type = $_SERVER['CONTENT_TYPE'] ?? '';

        if (stripos($content_type, 'application/json') !== false) {
            $rawData = file_get_contents('php://input');
            if($rawData)
            {
                $json = json_decode($rawData, true);
                return $json;
            }
        }


        if($method == 'post')
        {

            foreach($_POST as $key => $value)
            {
                if (is_array($value)) {
                    // If the value is an array, apply filtering/sanitization to each element
                    $sanitizedArray = [];
                    foreach ($value as $subKey => $subValue) {
                        $sanitizedArray[$subKey] = filter_var($subValue, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                    $body[$key] = $sanitizedArray;
                }else{
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }

        }else{
            foreach ($_GET as $key => $value) {
                if (is_array($value)) {
                    // If the value is an array, sanitize each element
                    $sanitizedArray = [];
                    foreach ($value as $subKey => $subValue) {
                        $sanitizedArray[$subKey] = filter_var($subValue, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                    $body[$key] = $sanitizedArray;
                } else {
                    // If the value is not an array, sanitize it directly
                    $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        return ($body);
    }



    /**
     * 
     * Get single posting result
     */
    public function input(string $data)
    {
        if(isset($this->all()[$data]))
        {
            return  $this->all()[$data];
        }
        
    }


    /**
     * 
     * Get single posting images or file
     */
    public function file(string $data)
    {
        if(isset($_FILES[$data]) && $_FILES[$data]['name'] != '')
        {
            return  $_FILES[$data];
        }
        
    }

    public function path()
    {
        return (Config::get('app.url').$_SERVER['REQUEST_URI']);
    }
}

?>