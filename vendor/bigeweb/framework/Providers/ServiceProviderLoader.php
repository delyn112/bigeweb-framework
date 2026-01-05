<?php

namespace illuminate\Support\Providers;

use illuminate\Support\Http\Controllers\BaseController;
use illuminate\Support\Routes\Dispatcher;

class ServiceProviderLoader
{

    public array $providers;
    public $viewPath = [];
    public $migrationPath = [];
    public  $langPath = [];

    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function loadServices()
    {
        foreach($this->providers as $provider)
        {
            if(class_exists($provider))
            {
                $providerInstance = new $provider;
                $providerInstance->register();

                if($providerInstance->viewDirectory !== null)
                {
                    $this->viewPath[] = $providerInstance->viewDirectory;
                }

                if($providerInstance->migrationFrom !== null)
                {
                    $this->migrationPath[] = $providerInstance->migrationFrom;
                }

                if($providerInstance->langDirectory !== null)
                {
                   $this->langPath[] = $providerInstance->langDirectory;
                }
            }else{
                throw new \Exception("Provider class not found: $provider", 404);
            }
        }

        /**
         *
         *
         * Store the view path in a file
         */

        $this->storeViewPath();
        $this->storeMigrationPath();
        $this->storeLangPath();
    }

    public function storeViewPath()
    {
        $storagePath = file_path('/vendor/bigeweb/viewsLocation');
        if(!is_dir($storagePath))
        {
            mkdir($storagePath, 0777, true);
        }

        $text = "<?php\nreturn [\n";
        $text .= implode(",\n", array_map(function($path) {
            // Normalize the path to use forward slashes
            $normalizedPath = str_replace('\\', '/', $path);
            return var_export($normalizedPath, true);
        }, $this->viewPath));
        $text .= "\n];\n?>";
        file_put_contents($storagePath . '/views.php', $text, LOCK_EX);
    }

    public function storeMigrationPath()
    {
        $storagePath = file_path('/vendor/bigeweb/migrationsLocation');
        if(!is_dir($storagePath))
        {
            mkdir($storagePath, 0777, true);
        }
        $text = "<?php\nreturn [\n";
        $text .= implode(",\n", array_map(function($path) {
            // Normalize the path to use forward slashes
            $normalizedPath = str_replace('\\', '/', $path);
            return var_export($normalizedPath, true);
        }, $this->migrationPath));
        $text .= "\n];\n?>";
        file_put_contents($storagePath . '/migration.php', $text, LOCK_EX);
    }


    public function storeLangPath()
    {
        $storagePath = file_path('/vendor/bigeweb/langLocation');
        if(!is_dir($storagePath))
        {
            mkdir($storagePath, 0777, true);
        }
        $text = "<?php\nreturn [\n";
        $text .= implode(",\n", array_map(function($path) {
            // Normalize the path to use forward slashes
            $normalizedPath = str_replace('\\', '/', $path);
            return var_export($normalizedPath, true);
        }, $this->langPath));
        $text .= "\n];\n?>";
        file_put_contents($storagePath . '/translation.php', $text, LOCK_EX);
    }
}