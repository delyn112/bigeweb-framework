<?php

namespace illuminate\Support\Requests;

class GenerateRequest
{

    public  $filename;
    public $path;


    public function __construct()
    {
        //get the provider name from the request uri
        $getRequestName = $_GET ?? '';

        if(!empty($getRequestName)){
            $this->filename = array_keys($getRequestName)[0];
        }

        $this->path = dirname(__DIR__, 4).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Requests';

        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }


    private function baseRequestName(): string
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
            $providerFile = $this->baseRequestName().'.php';

            //save the migration file into the correct location
            if($this->checkExistence($providerFile) != false)
            {
                file_put_contents($this->path.DIRECTORY_SEPARATOR.$providerFile, $this->requestData());
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

                if($file === $this->baseRequestName().'php'){
                    log_Error('Request '.$this->filename.' already exists:'.$filename);
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

    public function requestData()
    {
        $tmpName = $this->baseRequestName();

        $params = <<<EOD
    <?php
    namespace Bigeweb\App\Http\Requests;
    use illuminate\Support\Requests\Validation;
    
    class $tmpName extends Validation
    {
    
            /**
            *
            *
            *important validation keys
            * @return array
            *['required']
            *['unique', 'unique:users']
            *['email']
            *['min', 'min' => '8']
            *['max', 'max' => '20']
            *['match', 'match' => 'password']
            *['mimes', 'ext' =>'jpeg, png, jpg']
            *['image']
            *['size', 'size' => '2000']
            *
            *
            */

    
        public static function validate()
        {
            return Validation::attributes([
                'name' => ['required'],
                'email' => ['required', ['unique', 'unique:users'], 'email'],
                'username' => ['required', ['unique', 'admins:username']],
                'password' =>  ['required', ['min', 'min' => '8'], ['max', 'max' => '20']],
                'confirm_password' => ['required', ['match', 'match' => 'password']],
                'terms' => ['required'],
                'photo' => [['mimes', 'ext' =>'jpeg, png, jpg'], 'image', ['size', 'size' => '2000']]
            ]);
        }
    }
    EOD;

        return $params;

    }
}