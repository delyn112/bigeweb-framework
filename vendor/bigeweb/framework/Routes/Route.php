<?php
namespace illuminate\Support\Routes;


use illuminate\Support\Exceptions\httpPageNotFoundException;
use illuminate\Support\Requests\Request;

class Route{

    public $routes = [];
    public static $systemRoutes = [];

    /**
     * @param string $uri
     * @param mixed $callback
     * @return self
     *
     *
     */
    public static function get(string $uri, mixed $callback)
    {
        /**
         *
         * remove all extra slashed
         */
        $uri = trim($uri, '/');

        //split the uri
        $ArrayUri = explode('?', $uri);
        /**
         *
         * Get the first array element which will be our path or uri
         */
        $stringUri = reset($ArrayUri);

        if(substr($stringUri,  -1) == "/" || $stringUri)
        {
            //Globale url
            $gloabaluri = parse_url($_SERVER["REQUEST_URI"]);

            $queries = $_GET;
            unset($queries['url']);

            if(count($queries) > 0)
            {
                if(trim($gloabaluri["path"], '/').'/' == $stringUri || trim($gloabaluri["path"], '/') == $stringUri )
                {
                    $uri = $stringUri.'?'.$gloabaluri["query"];
                }
            }
        }

        $body = new self();
        $body->routes['get'] = [
            'uri' => $uri,
            'callback' => $callback,
            'middleware' => [],
            'remove_middleware' => [],
            'name' => null
        ];

        self::$systemRoutes[] = $body;
        return $body;
    }


    /**
     * @param string $uri
     * @param mixed $callback
     * @return self
     *
     */
    public static function post(string $uri, mixed $callback)
    {
        /**
         *
         * remove all extra slashed
         */
        $uri = trim($uri, '/');

        $body = new self();
        $body->routes['post'] = [
            'uri' => $uri,
            'callback' => $callback,
            'middleware' => [],
            'remove_middleware' => [],
            'name' => null
        ];

        self::$systemRoutes[] = $body;
        return $body;
    }


    /**
     * @param string $param
     * @return $this
     *
     * set name
     * This name will be used as shortcut to get the url
     */
    public function name(string $param)
    {
        $method = array_key_first($this->routes);
       $this->routes[$method]['name'] = $param;

          return $this;
    }

    /**
     * @param $param
     * @return $this
     *
     * Set the midleware in array
     */
    public function middleware(array $param)
    {
        $method = array_key_first($this->routes);
        $this->routes[$method]['middleware'] = $param;

        return $this;
    }

    /**
     * @param $param
     * @return $this
     *
     * Remove unwanted middlewares
     */
    public function WithoutMiddleware(array $param)
    {
        $method = array_key_first($this->routes);

        $this->routes[$method]['remove_middleware'] = $param;
        return $this;
    }


    public static function allroutes()
    {
        return self::$systemRoutes;
    }
}
?>