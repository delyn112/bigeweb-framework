<?php

namespace illuminate\Support\Providers;

use illuminate\Support\Http\Controllers\BaseController;
use illuminate\Support\Routes\Dispatcher;

class ServiceProviderLoader
{

    public array $providers;
    public $viewPath = [];

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

                $this->viewPath[] = $providerInstance->viewDirectory;
            }else{
                log_Error("Configuration file not found: $provider");
                throw new \Exception("Provider class not found: $provider", 404);
            }
        }
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
}