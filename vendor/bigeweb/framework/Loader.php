<?php

namespace illuminate\Support;

use illuminate\Support\Providers\ServiceProviderLoader;
use illuminate\Support\Routes\Cors;
use illuminate\Support\Routes\Dispatcher;
use illuminate\Support\Routes\generateUri;
use illuminate\Support\Facades\Config;

class Loader
{
    public function __construct()
    {

        //load providers
        $providerArray = [];
        $appConfig = getPath().'/config/app.php';
        if(file_exists($appConfig))
        {
           $appConfig = require $appConfig;
            if (isset($appConfig['providers']) && is_array($appConfig['providers'])) {
                $providerArray = $appConfig['providers'];
            }
        }

        $provider = new ServiceProviderLoader($providerArray);
        $provider->loadServices();

        // Load custom ini settings
        require file_path("config/ini.php"); // Load ini settings first
        //load cors
        Cors::handle();
        //load session
        (new SessionConfiguration());
       $session = new Session();
        //Handle all the website url;
        $dispatcher = new Dispatcher();
        $dispatcher->dispatch();
    }
}