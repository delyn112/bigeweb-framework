<?php

namespace illuminate\Support\Database;

use illuminate\Support\Models\Model;

class SchemaMigration
{

    private $model;
    protected $className = [];
    private $migrationFileArray = [];

    public function __construct()
    {
        $this->model = new Model();
    }


    public static function migrate()
    {
        $instance = new self();
        return $instance->processMigrations();
    }


    /**
     * @return array
     * @throws \Exception
     *
     */
    private function migrationFiles() : array
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

        /**
         *
         * Retrieve all migration files from all
         * registered provider
         *
         */
        $allproviderMigrations = require $baseMigrationPath;
        return $allproviderMigrations;
    }


    /**
     * @return self
     * @throws \Exception
     *
     */
    private function mergeMigrationFiles() : self
    {
        $files = $this->migrationFiles();
        if(count($files) <= 0)
        {
            return $this;
        }

        $firstMigrationFile = [];
        foreach($files as $migrationFile)
        {
            $getMigrationContent = scandir($migrationFile);
            if(count($getMigrationContent) > 0)
            {
                foreach ($getMigrationContent as $file) {
                    if ($file == "." || $file == "..") {
                        continue;
                    }
                    //run the migration table
                    if (strpos($file, 'create_table_migration') !== false) {
                        $firstMigrationFile[] = $migrationFile . '/' . $file;
                    }else{
                        $this->migrationFileArray[] = $migrationFile . '/' . $file;
                    }
                }
            }
        }
        $this->migrationFileArray = array_merge($firstMigrationFile, $this->migrationFileArray);
        return $this;
    }


    private function processMigrations()
    {
        $this->mergeMigrationFiles();
        $migratedFiles = array_column($this->appliedMigration(), 'migration');

        if(count($this->migrationFileArray) > 0)
        {
            foreach ($this->migrationFileArray as $migrationFile)
            {
                $fileName  = pathinfo($migrationFile, PATHINFO_FILENAME);
                if(!in_array($fileName, $migratedFiles))
                {
                    $this->runMigrationFile($migrationFile);
                    $this->storeMigrationTable($fileName);
                }
            }
        }
    }


    /**
     * @return array|null
     * Fecth all migrated table from database
     */
    private function appliedMigration() : ?array
    {
        try{
            $query = "SELECT migration FROM migrations";
            $stmt = $this->model->getConnection()->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
            return $result ? : [];
        }catch (\PDOException $e){
            return [];
        }
    }


    private function runMigrationFile(?string $filePath)
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
     *
     * Store migrations table into database
     */

    public function storeMigrationTable(string $param)
    {
        $query = "INSERT INTO migrations (migration) VALUES ('$param')";
        $this->model->getConnection()->exec($query);
    }


}