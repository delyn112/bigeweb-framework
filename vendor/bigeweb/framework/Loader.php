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
        //load cors
        Cors::handle();
        //change the application time zone
        date_default_timezone_set(Config::get('app.timezone'));
        //load session
        (new SessionConfiguration());

        //Handle all the website url;
        $dispatcher = new Dispatcher();
        $dispatcher->dispatch();
    }
}