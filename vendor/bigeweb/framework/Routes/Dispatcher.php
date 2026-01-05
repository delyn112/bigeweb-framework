<?php

namespace illuminate\Support\Routes;

use illuminate\Support\Exceptions\httpPageNotFoundException;
use illuminate\Support\Exceptions\MethodMissingException;
use illuminate\Support\Requests\Request;

class Dispatcher
{

    public Request $request;
    private $middlewareFiles;

    public function __construct()
    {
        $this->request = new Request();
        $this->middlewareFiles = require file_path('app/Http/Kennel.php');
    }

    /**
     * @return void
     *
     * process all registered routes
     */
    public function dispatch()
    {
        /**
         *
         * Declare the parameters
         */
        $routerPath = Router::getPath();
        $globalUri  = trim($routerPath, '/');
        $globalMethod = strtolower(Router::method());
        $routeGroup = Route::$systemRoutes;

        /***
         *
         *
         * Loop throught all the routes and compare with the url entered by the user
         *
         *
         */

        foreach ($routeGroup as $key => $route)
        {
            /**
             *
             * compare the request type
             *
             */

            if(array_key_first($route->routes) === $globalMethod)
            {
                /**
                 *
                 * Here we are grouping the routes to make sure all gets and post are in same match
                 * If same match then get the uri
                 *
                 */
                $path = $route->routes[$globalMethod]['uri'];
               if($path == $globalUri)
               {
                   $routeMiddleware = $route->routes[$globalMethod]['middleware'];
                   $unsedMiddleware = $route->routes[$globalMethod]['remove_middleware'];
                   $routeCallback = $route->routes[$globalMethod]['callback'];
                   /**
                    *
                    *
                    * immediately process the callback if the middleware is empty
                    *
                    */
                   if(empty($routeMiddleware))
                   {
                       $this->processCallBack($routeCallback);
                   }

                   /***
                    *
                    * process middleware if available
                    *Define the initial $next closure representing the final request handler
                    */

                   $next = function($request = null) use ($route, $globalMethod)
                   {
                        $this->processCallBack($route->routes[$globalMethod]['callback']);
                   };

                   /**
                    *
                    * Now that our middleware is not empty, We need to merge all the web middleware with the request
                    * uri middleware if the request uri middleware need web
                    *
                    */

                   $webMiddleware = $this->middlewareFiles['web'];
                   if(!empty($webMiddleware) && in_array('web', $routeMiddleware))
                   {
                       $routeMiddleware = array_merge(array_keys($webMiddleware), $routeMiddleware);
                   }

                   $middlewareArray = $this->combinedMiddleware();

                   /**
                    *
                    * Now filter the unsuable middlewaree
                    *
                    */
                   $routeMiddleware = array_diff($routeMiddleware, $unsedMiddleware);

                   foreach($middlewareArray as $middlewareArrayKey => $middlewareArrayValue)
                   {
                       foreach($routeMiddleware as $key => $middleware)
                       {
                           if($middleware == $middlewareArrayKey) {
                               if (!class_exists($middlewareArrayValue)) {
                                   throw new \Exception("Middleware error: Class $middlewareArrayValue does not exist");
                               }

                               $middlewareInstance = new $middlewareArrayValue();
                               if (!method_exists($middlewareInstance, "handle"))
                               {
                                   throw new \Exception("Middleware error: 'handle' method missing in $middlewareArrayValue");
                               }

                               //create a clossure for the current middleware
                               $currentMiddleware = function ($request) use ($middlewareInstance, $next)
                               {
                                   $middlewareInstance->handle($request, $next);
                               };

                               // Update $next for the next iteration
                               $next = $currentMiddleware;
                           }
                       }
                   }

                   /**
                    *
                    * Process the next stage using the next request
                    */


                   // Find the key of the value "web"
                   $key = array_search("web", $routeMiddleware);

                   if ($key !== false) {
                       unset($routeMiddleware[$key]);
                       // Optional: Reindex the array if needed
                       $routeMiddleware = array_values($routeMiddleware);
                   }
                   $firstMiddleware = array_pop($routeMiddleware);
                   if (in_array($firstMiddleware, array_keys($middlewareArray))) {
                       $firstMiddlewareClass = $middlewareArray[$firstMiddleware];
                       $firstMiddlewareInstance = new $firstMiddlewareClass();
                       return $firstMiddlewareInstance->handle(new Request(), $next);
                   }else{
                       $this->processCallBack($route->routes[$globalMethod]['callback']);
                   }

               }elseif(stripos($routerPath, '?') === 1){
                   /**
                    *
                    * If url path is embedded from external link then split the url and go to the base path of the url
                    *
                    *
                    */
                       $urlArray = explode('?', $routerPath);
                       $urlPath = reset($urlArray);
                       return header("Location: $urlPath");
               }
            }
        }

        echo httpPageNotFoundException::errorMessage();
    }


    private function processCallBack(mixed $callback)
    {
        /**
         *
         * process the given call back action
         *
         *
         */
        if (is_callable($callback)) {
            echo call_user_func($callback, $this->request);
        }else{
            $callback[0] = new $callback[0](); //get the first element array
            echo call_user_func($callback, $this->request);
        }
        exit();
    }

    private function combinedMiddleware()
    {
        $middlewareArray = [];
        foreach($this->middlewareFiles as $middleware)
        {
            $middlewareArray = array_merge($middlewareArray, $middleware);
        }

        return $middlewareArray;
    }

}