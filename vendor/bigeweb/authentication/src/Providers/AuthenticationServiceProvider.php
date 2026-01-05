<?php

namespace Bigeweb\Authentication\Providers;

use illuminate\Support\Providers\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadUrlFrom([__DIR__.'/../../routes/web.php',
            __DIR__.'/../../routes/profile.php']);
        $this->loadMigrationFrom([__DIR__ . '/../../database/migrations']);
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'auth');
        $this->loadTranslationFrom(__DIR__.'/../../resources/lang', 'auth');
    }
}