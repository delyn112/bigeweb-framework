<?php

namespace Bigeweb\App\Providers;

use illuminate\Support\Providers\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadUrlFrom([__DIR__.'/../../routes/web.php', __DIR__.'/../../routes/migration.php']);
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
    }
}