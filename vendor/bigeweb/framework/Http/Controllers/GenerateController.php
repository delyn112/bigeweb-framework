<?php

namespace illuminate\Support\Http\Controllers;

class GenerateController
{
    public  $filename;
    public $path;


    public function __construct()
    {
        //get the controller name from the request uri
        $getControllerName = $_GET ?? '';

        if(!empty($getControllerName)){
            $this->filename = array_keys($getControllerName)[0];
        }

        $this->path = dirname(__DIR__, 5).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers';

        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }


    private function baseControllerName(): string
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
            $controllerFile = $this->baseControllerName().'.php';

            //save the migration file into the correct location
            if($this->checkExistence($controllerFile) != false)
            {
                file_put_contents($this->path.DIRECTORY_SEPARATOR.$controllerFile, $this->controllerData());
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

                if($file === $this->baseControllerName() . '.php'){
                    log_Error('Controller '.$this->filename.' already exists:'.$filename);
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

    public function controllerData()
    {
        $tmpName = $this->baseControllerName();

        $params = <<<EOD
    <?php
    namespace Bigeweb\App\Http\Controllers;
    use illuminate\Support\Requests\Response;
    use illuminate\Support\Requests\Request;
        
        class $tmpName extends Controller
        {
        
             public function __construct()
            {
                parent::__construct();
            }
        
            /**
             * Display a listing of the resource (GET /posts).
             */
            public function index()
            {
                //
            }
        
            /**
             * Show the form for creating a new resource (GET /posts/create).
             */
            public function create()
            {
                //
            }
        
            /**
             * Store a newly created resource in storage (POST /posts).
             */
            public function store(Request \$request)
            {
                //
            }
        
            /**
             * Display the specified resource (GET /posts/{id}).
             */
            public function show(Request \$request)
            {
                //
            }
        
            /**
             * Show the form for editing the specified resource (GET /posts/{id}/edit).
             */
            public function edit(Request \$request)
            {
                //
            }
        
            /**
             * Update the specified resource in storage (PUT/PATCH /posts/{id}).
             */
            public function update(Request \$request)
            {
               //
            }
        
            /**
             * Remove the specified resource from storage (DELETE /posts/{id}).
             */
            public function destroy(Request \$request)
            {
                //
            }
        
            /**
             * Search posts by title or body (GET /posts/search?query=...).
             */
            public function search(Request \$request)
            {
                //
            }
        
            /**
             * Restore a soft-deleted post (POST /posts/{id}/restore).
             */
            public function restore(Request \$request)
            {
               //
            }
        
            /**
             * Permanently delete a soft-deleted post (DELETE /posts/{id}/force).
             */
            public function forceDelete(Request \$request)
            {
               //
            }
        
        }
    EOD;

        return $params;

    }
}