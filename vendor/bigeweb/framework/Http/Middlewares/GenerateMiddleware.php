<?php

namespace illuminate\Support\Http\Middlewares;

class GenerateMiddleware
{

    public  $filename;
    public $path;


    public function __construct()
    {
        //get the model name from the request uri
        $getMiddlewareName = $_GET ?? '';

        if(!empty($getMiddlewareName)){
            $this->filename = array_keys($getMiddlewareName)[0];
        }

        $this->path = dirname(__DIR__, 5).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Middlewares';

        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }


    private function baseMiddlewareName(): string
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
            $modelFile = $this->baseMiddlewareName().'.php';

            //save the migration file into the correct location
            if($this->checkExistence($modelFile) != false)
            {
                file_put_contents($this->path.DIRECTORY_SEPARATOR.$modelFile, $this->middlewareData());
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

                if($file === $this->baseMiddlewareName().'php'){
                    log_Error('Middleware '.$this->filename.' already exists:'.$filename);
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

    public function middlewareData()
    {
        $tmpName = $this->baseMiddlewareName();

        $params = <<<EOD
    <?php
    namespace Bigeweb\App\Http\Middlewares;

    use illuminate\Support\Requests\Request;
    
    class $tmpName
    {
    
        /**
        *
        * Handle an incoming request.
        * @param Request \$request
        * @param Callable \$next
        * @return mixed
        *
        */
        public function handle(Request \$request, Callable \$next)
        {
            return \$next(\$request);
        }
    }
    EOD;

        return $params;

    }
}