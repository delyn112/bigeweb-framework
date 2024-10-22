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
        $routeGroup = Config::get('app.routes');

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


        //Handle all the website url;
        (new Dispatcher())->dispatch();

    }
}