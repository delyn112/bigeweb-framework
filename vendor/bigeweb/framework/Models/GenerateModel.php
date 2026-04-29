<?php

namespace illuminate\Support\Models;

class GenerateModel
{

    public  $filename;
    public $path;


    public function __construct()
    {
        //get the model name from the request uri
        $getModelName = $_GET ?? '';

        if(!empty($getModelName)){
            $this->filename = array_keys($getModelName)[0];
        }

        $this->path = dirname(__DIR__, 4).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Models';

        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }


    private function baseModelName(): string
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
            $modelFile = $this->baseModelName().'.php';

            //save the migration file into the correct location
            if($this->checkExistence($modelFile) != false)
            {
                file_put_contents($this->path.DIRECTORY_SEPARATOR.$modelFile, $this->modelData());
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

                if($file === $this->baseModelName().'php'){
                    log_Error('Model '.$this->filename.' already exists:'.$filename);
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

    public function modelData()
    {
        $tmpName = $this->baseModelName();
        $tableName = strtolower($tmpName).'s';

        $params = <<<EOD
    <?php
    namespace Bigeweb\App\Models;
    use illuminate\Support\Models\Model;
        
        class $tmpName extends Model
        {
        
            protected \$table = '$tableName';
            
            
            public function getTableName()
            {
                return \$this->table;
            }
        }
    EOD;

        return $params;

    }
}