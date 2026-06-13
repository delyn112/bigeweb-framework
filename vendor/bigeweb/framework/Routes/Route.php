<?php
namespace illuminate\Support\Routes;


use Closure;
use illuminate\Support\Exceptions\httpPageNotFoundException;
use illuminate\Support\Requests\Request;

class Route{

    public $routes = [];
    public static $systemRoutes = [];
    private static $routePrefix = null;
    protected array $groupInstance = [];
    private static $groupMiddleware = [];

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

        $hasQuery = strpos($uri, '?');
        $body = new self();
        if($hasQuery){
           $uri = $body->enableQueryUrl($uri);
        }

        $uri = $body->enablePrettyUrl($uri);

        /**
         *
         * remove all extra slashed
         */
        $uri = trim($uri, '/');

        /**
         *
         *
         * Add prefix
         *
         */

        $prefix = self::getPrefix();

        if (!empty($prefix)) {
            $uri = trim($prefix . '/' . $uri, '/');
        }

        $body->routes['get'] = [
            'uri' => $uri,
            'callback' => $callback,
            'middleware' => self::$groupMiddleware,
            'remove_middleware' => [],
            'name' => null
        ];

        self::$systemRoutes[] = $body;
        return $body;
    }


    /**
     * @param string $uri
     * @return string|null
     *
     */
    private function enablePrettyUrl(string $uri) : ?string
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = ltrim($path, '/');
        $uri = ltrim($uri, '/');
        /**
         *
         * The the matches and extract the key and value
         */
        preg_match_all('/\{([^}]+)\}/', $uri, $keys);


        // Convert route to regex
        $regex = preg_replace('/\{[^}]+\}/', '([^/]+)', $uri);
        $regex = '#^' . $regex . '$#';

        if (preg_match($regex, $path, $matches)) {

            array_shift($matches);

            $queryParams = array_combine($keys[1], $matches);

            //set the params to basic routing method
            $_GET = $queryParams;
            $uri = $path;
        }
        return $uri;
    }


    /**
     * @param string $uri
     * @return string|null
     *
     *
     */
    private function enableQueryUrl(string $uri) : ?string
    {
        //split the uri
        $ArrayUri = explode('?', $uri);
        /**
         *
         * Get the first array element which will be our path or uri
         */
        $stringUri = reset($ArrayUri);

        if(substr($stringUri,  -1) == "/" || $stringUri)
        {
            //Global url
            $globaluri = parse_url($_SERVER["REQUEST_URI"]);
            $queries = $_GET;
            unset($queries['url']);

            if(count($queries) > 0)
            {
                if(trim($globaluri["path"], '/').'/' == $stringUri
                    || trim($globaluri["path"], '/') == $stringUri )
                {
                    $uri = $stringUri.'?'.$globaluri["query"];
                }
            }
        }

        return $uri;
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

        $prefix = self::getPrefix();

        if (!empty($prefix)) {
            $uri = trim($prefix . '/' . $uri, '/');
        }


        $body = new self();
        $body->routes['post'] = [
            'uri' => $uri,
            'callback' => $callback,
            'middleware' => self::$groupMiddleware,
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
        $this->routes[$method]['middleware'] = array_merge($this->routes[$method]['middleware'] ,
        $param);
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


    /**
     * @param array $attributes
     * @param Closure $callback
     * @return void
     *
     */
    public static function group(array $attributes, Closure $callback) : void
    {
        $previousPrefix = self::$routePrefix;
        $previousMiddleware = self::$groupMiddleware;

        foreach ($attributes as $key => $value) {
            if (strtolower($key) === 'prefix') {
                self::$routePrefix = trim($previousPrefix . '/' . trim($value, '/'), '/');
            }elseif(strtolower($key) === 'middleware')
            {
                self::$groupMiddleware = array_merge(
                    self::$groupMiddleware,
                    (array) $value
                );
            }
        }

        $callback(); // IMPORTANT: execute routes inside group

        self::$routePrefix = $previousPrefix; // restore
        self::$groupMiddleware = $previousMiddleware;
    }



    /**
     * @return string|null
     */
    public static function getPrefix(): ?string
    {
        return self::$routePrefix;
    }

    /**
     * @return array
     *
     */
    public static function allroutes()
    {
        return self::$systemRoutes;
    }
}
?>