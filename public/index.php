<?php

use illuminate\Support\Facades\Config;

require(__DIR__.'/../vendor/autoload.php');


date_default_timezone_set(Config::get('app')['timezone']);

new \illuminate\Support\Routes\generateUri();

?>