<?php

namespace illuminate\Support\Database;

class MakeMigration
{

    public $timeStamp;
    public  $filename;
    public $path;


    public function __construct()
    {
        //get the table name from the request uri
        $getTableName = $_GET ?? '';

        if(!empty($getTableName)){
            $this->filename = array_keys($getTableName)[0];
        }

        $this->timeStamp = date('Y_m_d_His');
        $this->path = dirname(__DIR__, 4).DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';

        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }


    private function baseMigrationName(): string
    {
        return 'create_table_' . $this->filename;
    }

    /**
     * @return void
     *
     * Make the migration file according to the input given
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
            $migrationFile = "{$this->baseMigrationName()}_{$this->timeStamp}.php";

            //save the migration file into the correct location
            if($this->checkExistence($migrationFile) != false)
            {
                file_put_contents($this->path.DIRECTORY_SEPARATOR.$migrationFile, $this->migrationData());
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

                if(stripos($file, $this->baseMigrationName()) === 0){
                    log_Error('Migration for table '.$this->filename.' already exists:'.$filename);
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

    public function migrationData()
    {
        $tmpName = "{$this->baseMigrationName()}_{$this->timeStamp}";
        $tableName = $this->filename;

        $params = <<<EOD
    <?php
    namespace Database\Migrations;
        use illuminate\Support\Database\Schema;
        class $tmpName
        {
        
         /**
         * @return void
         *
         * Use to load the  migration
         */
     
     
            public function up()
            {
                 Schema::create('$tableName', function (\$table){
                    \$table->id();
                    \$table->timestamps();
                 });
     
            }
            
            
        /**
         * @return null
         *
         * Use to drop the database table
         * Reverse migration process
         */
            /**
             * Reverse the migrations.
             */
            public function down(): void
            {
                Schema::drop('$tableName');
            }
        }
    EOD;

        return $params;

    }
}
