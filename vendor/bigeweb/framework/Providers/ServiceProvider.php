<?php

namespace illuminate\Support\Providers;

use illuminate\Support\Facades\Config;

class ServiceProvider
{
   public $loadUrlFrom;
   public $loadConfigFrom;
   public $viewDirectory;
   public $migrationFrom;


   public function loadUrlFrom(mixed $fileDirectory)
   {
       if(is_array($fileDirectory))
       {
           $arrayFiles = $fileDirectory;
       }else{
           $arrayFiles = array($fileDirectory);
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


   public function loadconfigFrom(mixed $fileDirectory)
   {
       if(is_array($fileDirectory))
       {
           $arrayFiles = $fileDirectory;
       }else{
           $arrayFiles = array($fileDirectory);
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

   public function loadViewsFrom(string $fileDirectory, ?string $viewName = null)
   {
       if(!is_dir($fileDirectory))
       {
           error_log("Views folder does not exists: $fileDirectory");
       }

       if($viewName == null)
       {
           $this->viewDirectory = $fileDirectory;
       }else{
           $this->viewDirectory = $fileDirectory.'::'.$viewName;
       }

   }

       public function viewPath()
       {
          return $this->viewDirectory;
       }

    public function loadMigrationFrom(mixed $fileDirectory)
    {
        if(is_array($fileDirectory))
        {
            $arrayFiles = $fileDirectory;
        }else{
            $arrayFiles = array($fileDirectory);
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
}