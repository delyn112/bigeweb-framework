<?php

require __DIR__.'/../vendor/autoload.php';
use Bigeweb\App\Consoles\RunCommands;

$provider = new \illuminate\Support\Providers\ServiceProvider();
$configFiles = scandir( __DIR__.'/../config');

$providerFile = [];
if(count($configFiles) > 0){
    foreach ($configFiles as $file) {
        if($file == '.' || $file == '..')
        {
            continue;
        }

        $providerFile[] = __DIR__.'/../config/'.$file;
        //$provider->loadconfigFrom(__DIR__.'/../config/'.$file);
    }

    $provider->loadconfigFrom($providerFile);
}

require __DIR__."/../config/ini.php";


//run the commands
$cronjobFile = RunCommands::class;
if(class_exists($cronjobFile))
{
    $cronjob = new RunCommands();
   return $cronjob->boot();
}