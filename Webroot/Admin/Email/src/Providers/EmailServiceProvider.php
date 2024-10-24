<?php
namespace Bigeweb\Email\Providers;
use illuminate\Support\Providers\ServiceProvider;

class EmailServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadUrlFrom([__DIR__.'/../../routes/web.php']);
        $this->loadconfigFrom([__DIR__.'/../config/email.php']);
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'email');
    }

}