<?php

namespace illuminate\Support;

use illuminate\Support\Routes\Cors;
use illuminate\Support\Routes\generateUri;
use illuminate\Support\Facades\Config;

class Loader
{
    public function __construct()
    {
        //load cors
        Cors::handle();
        //change the application time zone
        date_default_timezone_set(Config::get('app.timezone'));
        //load session
        (new SessionConfiguration());

        //load the uri
        (new generateUri());
    }
}