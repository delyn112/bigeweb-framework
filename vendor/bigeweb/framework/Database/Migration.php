<?php

namespace illuminate\Support\Database;

use http\Exception\InvalidArgumentException;
use illuminate\Support\Facades\Config;
use illuminate\Support\Models\model;

class Migration{
   // use db;

    public $Model;
    protected $className = [];

    public function __construct()
    {
       $this->Model = new model();
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
    //run migration table first
    $initialMigration = 'app\database\migrations\create_table_migration_20250417_204906';
        if(!class_exists($initialMigration))
        {
           log_Error("Class $initialMigration does not exist");
           throw new \Exception("Class $initialMigration does not exist");
        }
        $fileClassInstance = new $initialMigration();
        if(!method_exists($fileClassInstance, 'up'))
        {
            log_Error("Class $initialMigration does not have up");
            throw new \Exception("Class $initialMigration does not have up");
        }elseif(!empty($fileClassInstance->up()))
        {
            $this->Model->getConnection()->exec($fileClassInstance->up());
        }



        //get the providers migration files
    $appMigration = Config::get('database.migrations');
    //add base directory to the migration name
    $migrationFiles = [];
      if(count($appMigration) > 0)
      {
          foreach($appMigration as $file)
          {
              $migrationFiles[] = file_path($file);
          }
      }

    $providerMigrationPath = file_path("vendor/bigeweb/migrationsLocation/migration.php");
    if(!file_exists($providerMigrationPath))
    {
        log_Error("$providerMigrationPath file does not exist");
        throw new \Exception("$providerMigrationPath file does not exist");
    }
    $providerMigrationPath = require $providerMigrationPath;

   if(count($providerMigrationPath) > 0)
   {
       $migrationFiles = array_merge($migrationFiles, $providerMigrationPath);
   }


   $newMigrationFile = [];
   $fullMigrationFilePath = [];
   //get the file name and also the full path
    //The file name will be used to seperate newmigration from applied migrations
   if(count($migrationFiles) > 0)
   {
       foreach($migrationFiles as $migrationFile)
       {
           $getMigrationFile = scandir($migrationFile);
           if(count($getMigrationFile) > 0)
           {
               foreach ($getMigrationFile as $file) {
                   if($file == "." || $file == "..")
                   {
                       continue;
                   }
                   $newMigrationFile[] = rtrim( $file, ".php");
                   $fullMigrationFilePath[] = $migrationFile.'/'.$file;
               }
           }
       }
   }

   //get the applied migration difference
    $applied_migration = $this->appliedMigration();
    $toapply_migration = array_diff( $newMigrationFile,  $applied_migration);
    sort($toapply_migration);


    foreach($fullMigrationFilePath as $fileToMigrate)
    {
        $getMigrationName = pathinfo($fileToMigrate, PATHINFO_FILENAME);
        foreach ($toapply_migration as $migration)
        {
            if($migration === $getMigrationName)
            {
                if(!file_exists($fileToMigrate))
                {
                    log_Error("$fileToMigrate file does not exist");
                    throw new \Exception("$fileToMigrate file does not exist");
                }
                $fileContents = file_get_contents($fileToMigrate);
                // Use a regex pattern to find the namespace
                if (preg_match('/^\s*namespace\s+([^;]+);/m', $fileContents, $matches)) {
                    $namespace = trim($matches[1]); // Return the matched namespace
                }
                $className = $namespace.DIRECTORY_SEPARATOR.$migration;
                $fileClassInstance = new $className();
                $this->className[] = $fileClassInstance;

                //check if method up exist
                if(!method_exists($fileClassInstance, 'up'))
                {
                    log_Error("Class $className does not have up");
                    throw new \Exception("Class $className does not have up");
                }
                if($fileClassInstance->up() != null || $fileClassInstance->up() != "")
                {
                    $table = $fileClassInstance->up();
                    $this->Model->getConnection()->exec($table);
                    $this->storeMigrationTable($getMigrationName);
                }

            }
        }

    }

}


/**
 * 
 * Fecth all migrated table from database
 * column
 */
public function appliedMigration()
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

/**
 * 
 * Drop all database
 */

public function dropdatabase()
{
    $this->Model->dropDatabase();
    $this->Model->createDatabase();
}

}

?>