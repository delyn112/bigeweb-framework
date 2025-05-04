<?php

namespace illuminate\Support;

use illuminate\Support\Facades\Config;

class Session
{
    protected const KEY= "flash_messages";
    public function __construct()
    {
        $messages = $_SESSION[self::KEY] ?? [];
        foreach($messages as $key => &$i)
        {
            $i['status'] = true;
        }
        $_SESSION[self::KEY] = $messages;
    }


    public static function flash($key, $message)
    {
        return $_SESSION[self::KEY][$key] = [
            'message' => $message,
            'status' => false,
        ];
    }


    public static function get($key)
    {
        $message = $_SESSION[self::KEY][$key]['message'] ?? false;
        echo "<script>$(document).ready(function(){
            setTimeout(function (){ $('.alert').fadeOut('slow')}, 5000);
        })</script>";
        return $message;

    }

    public static  function session_set(string $key, mixed $value)
    {
        return  $_SESSION[$key] = $value;
    }

    public static function session_get(string $key)
    {
        if(isset($_SESSION[$key]))
        {
            $section_data = $_SESSION[$key];

            if($section_data)
            {
                return $section_data;
            }

            return null;
        }
    }

    public static function session_delete(string $param)
    {
        unset($_SESSION[$param]);
    }

    public static function session_flush()
    {
        session_unset();
        session_destroy ();
    }


    public function __destruct()
    {
        $messages = $_SESSION[self::KEY] ?? [];
        foreach($messages as $key => &$i)
        {

            if($i['status'])
            {
                unset($messages[$key]);

            }
        }
        $_SESSION[self::KEY] = $messages;
    }

}