<?php
namespace illuminate\Support\Routes;


class Router
{
        protected static $method;
        protected static $uri;

        public static function method()
        {
        self::$method = $_SERVER['REQUEST_METHOD'];
        return self::$method;
        }


        public static function url()
        {
        return self::$uri = $_SERVER['REQUEST_URI'];
        }


        public static function getPath()
        {
            return self::url();
        }
}
?>