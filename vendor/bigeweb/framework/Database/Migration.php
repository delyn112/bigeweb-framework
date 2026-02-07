<?php

namespace illuminate\Support\Database;

use http\Exception\InvalidArgumentException;
use illuminate\Support\Facades\Config;
use illuminate\Support\Models\Model;

class Migration{
    // use db;

    public $Model;
    protected $className = [];

    public function __construct()
    {
        $this->Model = new Model();
    }


    /**
     *
     * functions to migrate databases
     */
    public function migrate()
    {
        return $this->processMigration();
    }

    /**
     *
     * function to drop databases
     */
    public function migration_rollback()
    {
        return $this->dropdatabase();
    }


    /**
     *
     * Read through the migration folder
     * scan the folder and select the name
     * use the name excluding the path to create the migration
     */

    public function processMigration()
    {
        $baseMigrationPath = file_path("vendor/bigeweb/migrationsLocation/migration.php");
        /**
         *
         * throw error if the file does not exist
         *
         */

        if(!file_exists($baseMigrationPath))
        {
            throw new \Exception("$baseMigrationPath file does not exist");
        }
        $allproviderMigrations = require $baseMigrationPath;

        /**
         *
         * get the file name and also the full path
         * The file name will be used to seperate newmigration from applied migrations
         *
         */

        if(count($allproviderMigrations) > 0)
        {
            foreach($allproviderMigrations as $migrationFile)
            {
                $getMigrationContent = scandir($migrationFile);

                if(count($getMigrationContent) > 0)
                {
                    foreach ($getMigrationContent as $file) {
                        if($file == "." || $file == "..")
                        {
                            continue;
                        }

                        //run the migration table
                        if(strpos($file, 'create_table_migration') !== false) {
                           $this->runMigrationFile($migrationFile.'/'.$file);
                        }else{
                            $migrationFileArray[] = $migrationFile.'/'.$file;
                        }
                    }
                }
            }
        }

        /**
         *
         * get the applied migration difference
         *
         */
        $applied_migration = $this->appliedMigration();


        if(count($migrationFileArray) > 0)
        {
            foreach ($migrationFileArray as $migrationFile)
            {
                $fileName  = pathinfo($migrationFile, PATHINFO_FILENAME);
                if(!in_array($fileName, $applied_migration))
                {
                    $this->runMigrationFile($migrationFile);
                    $this->storeMigrationTable($fileName);
                }
            }
        }
    }



    public function runMigrationFile(?string $filePath)
    {
        $getFileName = pathinfo($filePath, PATHINFO_FILENAME);
        $fileContent = file_get_contents($filePath);
        $namespace = null;

        // Use a regex pattern to find the namespace
        if (preg_match('/^\s*namespace\s+([^;]+);/m', $fileContent, $matches)) {
            $namespace = trim($matches[1]); // Return the matched namespace
        }

        $fileClassName = $namespace.'\\'.$getFileName;

        if (!class_exists($fileClassName)) {
            throw new \Exception("Class $fileClassName does not exist");
        }

        $fileClassInstance = new $fileClassName();

        if (!method_exists($fileClassInstance, 'up')) {
            throw new \Exception("Class $fileClassName does not have up");
        }
        //run the migration
        $fileClassInstance->up();
    }


    /**
     * @return array|null
     * Fecth all migrated table from database
     */
    public function appliedMigration() : ?array
    {
        $statement = $this->Model->query("SELECT migration FROM migrations")->get();
        $result = [];
        foreach($statement as $stmt)
        {
            $result[] = $stmt->migration;
        }
        return ($result);
    }


    /**
     *
     * Store migrations table into database
     */

    public function storeMigrationTable(string $param)
    {
        $query = "INSERT INTO migrations (migration) VALUES ('$param')";
        $this->Model->getConnection()->exec($query);
    }

}

?>