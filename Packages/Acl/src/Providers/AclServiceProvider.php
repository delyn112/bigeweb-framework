<?php

namespace Bigeweb\Acl\Providers;

use illuminate\Support\Providers\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadUrlFrom([__DIR__.'/../../routes/web.php']);
        $this->loadMigrationFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'acl');
    }

}