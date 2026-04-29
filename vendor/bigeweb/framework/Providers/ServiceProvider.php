<?php

namespace illuminate\Support\Providers;

use illuminate\Support\Facades\Config;

class ServiceProvider
{
    public $loadUrlFrom;
    public $loadConfigFrom;
    public $viewDirectory;
    public $migrationFrom;
    public $langDirectory;


   public function loadUrlFrom(mixed $path)
   {
       if(is_array($path))
       {
           $arrayFiles = $path;
       }else{
           $arrayFiles = array($path);
       }

       if(count($arrayFiles) > 0)
       {
           foreach($arrayFiles as $file)
           {
               if(file_exists($file)){
                   require $file;
               }else{
                  log_Error("Route file not found: $file");
                   throw new \Exception("Route file not found: $file", 404);
               }
           }
       }
   }


   public function loadconfigFrom(mixed $path)
   {
       if(is_array($path))
       {
           $arrayFiles = $path;
       }else{
           $arrayFiles = array($path);
       }

       if(count($arrayFiles) > 0)
       {
           foreach($arrayFiles as $file)
           {
               if(file_exists($file)){
                 Config::load($file);
               }else{
                   log_Error("Configuration file not found: $file");
                   throw new \Exception("Configuration file not found: $file", 404);
               }
           }
       }
   }

   public function loadViewsFrom(string $path, ?string $packageName = null)
   {
       if(!is_dir($path))
       {
           error_log("Views folder does not exists: $path");
       }

       if($packageName == null)
       {
           $this->viewDirectory = $path;
       }else{
           $this->viewDirectory = $path.'::'.$packageName;
       }

   }

       public function viewPath()
       {
          return $this->viewDirectory;
       }

    public function loadMigrationFrom(mixed $path)
    {
        if(is_array($path))
        {
            $arrayFiles = $path;
        }else{
            $arrayFiles = array($path);
        }

        if(count($arrayFiles) > 0)
        {
            foreach($arrayFiles as $file)
            {
                if(file_exists($file)){
                 $this->migrationFrom = $file;
                }else{
                    log_Error("Configuration file not found: $file");
                    throw new \Exception("Configuration file not found: $file", 404);
                }
            }
        }
    }

    public function migrationDir()
    {
        return $this->migrationFrom;
    }


    public function loadTranslationFrom(string $path, ?string $packageName = null)
    {
        if(!is_dir($path))
        {
            error_log("Views folder does not exists: $path");
        }

        if($packageName == null)
        {
            $this->langDirectory = $path;
        }else{
            $this->langDirectory = $path.'::'.$packageName;
        }
    }

    public function langPath()
    {
       return $this->langDirectory;
    }
}