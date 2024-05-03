<?php

namespace illuminate\Support\Routes;
use bigeweb\app\Providers\AdminAuthServiceProvider;
use config\Session;
use illuminate\Support\Facades\BaseControllerFacades;
use illuminate\Support\Facades\Config;
use illuminate\Support\Routes\Route;

class generateUri
{
    public function __construct()
    {
        $routeGroup = Config::get('app')['routesFrom'];

           foreach($routeGroup as $routeFolder)
           {
               $routePath = scandir($routeFolder);
               foreach($routePath as $path)
               {
                   if($path == '.' || $path == '..')
                   {
                       continue;
                   }

                   require ($routeFolder.'/'.$path);
               };
           }



        Config::get('ini');

        $_SESSION['timeout'] = BaseControllerFacades::session_time();

        if (isset($_SESSION['timeout']) && time() > $_SESSION['timeout']) {
            // Session has timed out, destroy the session and redirect to login page
            session_unset();
            session_destroy();
            header("Location: /");
            exit();
        }

        $session = new \config\Session();
        //Handle all the website url;
        (new Dispatcher())->dispatch();


    }
}