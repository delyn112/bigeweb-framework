<?php

namespace illuminate\Support\Providers;

class GenerateProvider
{

    public  $filename;
    public $path;


    public function __construct()
    {
        //get the provider name from the request uri
        $getProviderName = $_GET ?? '';

        if(!empty($getProviderName)){
            $this->filename = array_keys($getProviderName)[0];
        }

        $this->path = dirname(__DIR__, 4).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Providers';

        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }


    private function baseProviderName(): string
    {
        return  ucfirst($this->filename);
    }

    /**
     * @return void
     *
     * Make the model file according to the input given
     */
    public function make()
    {
        try{
            $this->file();

        }catch (\Exception $e){
            log_Error($e->getMessage());
        }
    }


    /**
     * @return void
     *
     *
     */
    public function file()
    {
        if($this->filename){
            $providerFile = $this->baseProviderName().'.php';

            //save the migration file into the correct location
            if($this->checkExistence($providerFile) != false)
            {
                file_put_contents($this->path.DIRECTORY_SEPARATOR.$providerFile, $this->providerData());
            }
        }
    }


    /**
     * @param string $filename
     * @return bool
     *
     *
     */
    public function checkExistence(string $filename)
    {
        $files = scandir($this->path);
        if(count($files) > 0 ){
            foreach ($files as $file){
                if($file == '.' || $file == '..'){
                    continue;
                }

                if($file === $this->baseProviderName().'php'){
                    log_Error('ServiceProvider '.$this->filename.' already exists:'.$filename);
                    return false;
                }
            }
        }
        return true;
    }


    /**
     * @return string
     *
     */

    public function providerData()
    {
        $tmpName = $this->baseProviderName();

        $params = <<<EOD
    <?php
    
    namespace Bigeweb\App\Providers;
    
    
    use illuminate\Support\Providers\ServiceProvider;
        
        class $tmpName extends ServiceProvider
        {
        
          /**
           * @return void
           *
           * register your services
           */
            
            
        public function register()
        {
            //todo register your service provider
        }
        
        /**
           * @return void
           *
           * register other services
           */
        public function boot()
        {
            //todo boot your service provider
        }
    }
    EOD;

        return $params;

    }
}