<?php

namespace Bigeweb\App\Providers;

use illuminate\Support\Providers\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {

        //get the routes
       $this->getRoutes();

        $configFiles = scandir( __DIR__.'/../../config');
        if(count($configFiles) > 0){
            foreach ($configFiles as $file) {
                if($file == '.' || $file == '..')
                {
                    continue;
                }
                $this->loadconfigFrom(__DIR__.'/../../config/'.$file); // Load each config file
            }
        }
        $this->loadViewsFrom(__DIR__.'/../../resources/views');
        $this->loadTranslationFrom( __DIR__.'/../../resources/lang');
    }


    public function getRoutes()
    {
        $urlPath = scandir(__DIR__.'/../../routes');
        if(count($urlPath) > 0){
            foreach ($urlPath as $file) {
                if($file == '.' || $file == '..')
                {
                    continue;
                }
                $this->loadUrlFrom(__DIR__.'/../../routes/'.$file); // Load each config file
            }
        }
    }
}