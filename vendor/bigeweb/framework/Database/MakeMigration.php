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
        
        class $tmpName
        {
        
         /**
         * @return void
         *
         * Use to load the  migration
         */
     
     
            public function up()
            {
                return "CREATE TABLE IF NOT EXISTS $tableName (
                id INT(6) AUTO_INCREMENT PRIMARY KEY,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";
     
            }
            
            
        /**
         * @return null
         *
         * Use to drop the database table
         * Reverse migration process
         */
            public function down()
            {
                return "DROP TABLE $tableName";
            }
        }
    EOD;

        return $params;

    }
}
