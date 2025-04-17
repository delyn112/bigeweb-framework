<?php

namespace illuminate\Support\Routes;

use illuminate\Support\Exceptions\httpPageNotFoundException;
use illuminate\Support\Exceptions\MethodMissingException;
use illuminate\Support\Requests\Request;

class Dispatcher
{

    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * @return void
     *
     * process all registered routes
     */
    public function dispatch()
    {
        //server requested uri
        $global_uri = trim(Router::getPath(), '/');
        //global method from server
        $global_method = strtolower(Router::method());
        $request = $this->request;

        //loop through all the routes
        foreach(Route::$systemRoutes as $routegroup)
        {
            //check if the method is post or get
            if(array_key_first($routegroup->routes) === $global_method)
            {
                $pathUri = $routegroup->routes[$global_method]['uri'];
                //check if our registed route is same as the global routes
                if($pathUri == $global_uri)
                {
                    //check and process midlewares
                    if(!empty($routegroup->routes[$global_method]["middleware"]))
                    {
                        //loop thought the middleware file and combine the values
                        $middlewareFiles = require file_path('app/Http/Kennel.php');
                      $middlewareToArray = [];
                      foreach($middlewareFiles as $middlewareString)
                      {
                          $middlewareToArray = array_merge($middlewareToArray, $middlewareString);
                      }

                        // Define the initial $next closure representing the final request handler
                        $next = function ($request) use ($routegroup, $global_method) {
                            $callback = $routegroup->routes[$global_method]['callback'];
                            if (is_callable($callback)) {
                                echo call_user_func($callback, $request);
                            } else {
                                $callback[0] = new $callback[0]();
                                echo call_user_func($callback, $request);
                            }
                            exit();
                        };

                      //merge all the keys in web with the current route middlewarea
                        if(in_array('web', array_reverse($routegroup->routes[$global_method]["middleware"])))
                        {
                            $routegroup->routes[$global_method]["middleware"] = array_merge($routegroup->routes[$global_method]["middleware"], array_keys($middlewareFiles['web']));
                        }

                        //remove unwanted middlewares
                        $processable_middleware = array_diff(array_reverse( $routegroup->routes[$global_method]['middleware']),
                            array_reverse( $routegroup->routes[$global_method]['remove_middleware']));

                        //remove web from te middlewares
                        $processable_middleware = array_diff($processable_middleware, ['web']);

                        // Loop through middlewares and compose the $next closure
                        foreach($processable_middleware as $middleware)
                        {
                            if(array_key_exists($middleware, $middlewareToArray))
                            {
                               $currentMiddleware = $middlewareToArray[$middleware];
                               //check if the the middleware class exist
                                if(class_exists($currentMiddleware))
                                {
                                   $middlewareinstance = new $currentMiddleware();
                                   //check if the class has method handle
                                    if(method_exists($middlewareinstance, "handle"))
                                    {
                                        //create a clossure for the current middleware
                                        $MiddlewareNow = function ($request) use ($middlewareinstance, $next)
                                        {
                                            $middlewareinstance->handle($request, $next);
                                        };

                                        // Update $next for the next iteration
                                        $next = $MiddlewareNow;
                                    }else{
                                        MethodMissingException::message("Middleware error: 'handle' method missing in $currentMiddleware");
                                    }
                                }else{
                                    MethodMissingException::message("Middleware error: Class $middlewareClass does not exist");
                                }
                            }else{
                               MethodMissingException::message("Middleware error: $middlewareClass does not exist in list of middlewares");
                            }
                        }

                        //after checking for all the middleware
                        //now let the application run
                        $firstMiddleware = array_pop($processable_middleware);
                        if (in_array($firstMiddleware, array_keys($middlewareToArray))) {
                            $firstMiddlewareClass = $middlewareToArray[$firstMiddleware];
                            $firstMiddlewareInstance = new $firstMiddlewareClass();
                            return $firstMiddlewareInstance->handle(new Request(), $next);
                        }

                    }else{
                        //if middlewares are empty, execute without middleware
                        $callback = $routegroup->routes[$global_method]['callback'];
                        if (is_callable($callback)) {
                            echo call_user_func($callback, $request);
                        } else {
                            $callback[0] = new $callback[0]();
                            echo call_user_func($callback, $request);
                        }
                        exit();
                    }
                }

            }


        }
        echo httpPageNotFoundException::errorMessage();

    }

}