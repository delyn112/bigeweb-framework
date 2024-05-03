<?php

namespace config;

use illuminate\Support\Facades\BaseControllerFacades;

class Cookies
{

    public static $key = '';
    public static $value = '';
    public  $time = '';


    public function __construct()
    {
        $this->time = BaseControllerFacades::cookies_time();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     *
     *
     */
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
    }

    public static function destroy(string $key, mixed $value)
    {
        self::$key = $key;
        self::$value = $value;
        setcookie(self::$key, self::$value,  time() - 3600, "/");

    }
}