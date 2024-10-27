<?php

namespace Bigeweb\App\Providers;

use illuminate\Support\Providers\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadUrlFrom([__DIR__.'/../../routes/web.php', __DIR__.'/../../routes/migration.php']);
        $this->loadconfigFrom([__DIR__.'/../../config/app.php',
            __DIR__.'/../../config/cors.php',
            __DIR__.'/../../config/database.php',
            __DIR__.'/../../config/ini.php',
            __DIR__.'/../../config/Session.php',
            __DIR__.'/../../config/storage.php',
        ]);
        $this->loadViewsFrom(__DIR__.'/../../resources/views');
    }
}