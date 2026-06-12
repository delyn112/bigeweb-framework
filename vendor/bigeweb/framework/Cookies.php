<?php

namespace illuminate\Support;

use illuminate\Support\Facades\Config;

class Cookies
{

    public static $key = '';
    public static $value = '';
    public  $time = '';

    public function __construct()
    {
        $this->time = Config::get('Session.lifetime');
    }


    public static function set(string $key, mixed $value)
    {
        self::$key = $key;
        self::$value = $value;
        $timer = new self();
        setcookie(self::$key, self::$value, $timer->time, "/");

    }

    /**
     * @param string $key
     * @return mixed|void
     *
     *
     */
    public static function get(string $key)
    {
        self::$key = $key;
        if(isset( $_COOKIE[self::$key]))
        {
            return $_COOKIE[self::$key];
        }
        return null;
    }

    public static function destroy(string $key, mixed $value)
    {
        self::$key = $key;
        self::$value = $value;
        setcookie(self::$key, self::$value,  time() - 3600, "/");

    }
}