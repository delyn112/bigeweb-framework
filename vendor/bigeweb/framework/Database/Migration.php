<?php

namespace illuminate\Support\Database;

use illuminate\Support\Facades\Config;
use illuminate\Support\Models\model;

class Migration{
   // use db;

    public $Model;

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
    $classname = 'app\database\migrations\migration_001';
    $instance = new $classname();
   $this->Model->getConnection()->exec($instance->up());


   // $migration_file = scandir(asset('database/migrations'));
    $migration_source = Config::get('app')['migrationsFrom'];
    $migrationArray = [];
    $directory = [];
    foreach ($migration_source as $Directory)
    {
        $directory[] = $Directory;
        if(is_dir($Directory)){
        $migration_file = scandir($Directory);
        foreach($migration_file as $fileContent)
        {
            if($fileContent == ' ' || $fileContent == '.' || $fileContent == '..')
            {
                continue;
            }
            $migrationArray[] = str_replace('.php', '' , $fileContent);
        }
        }
    }

    $applied_migration = $this->appliedMigration();
    $toapply_migration = array_diff( $migrationArray,  $applied_migration);
    sort($toapply_migration);

    foreach($toapply_migration as $file)
    {
        foreach($directory as $dirHolder)
        {
            if(file_exists($dirHolder.DIRECTORY_SEPARATOR.$file.'.php'))
            {
                $class_code = file_get_contents($dirHolder . DIRECTORY_SEPARATOR . $file . '.php');
                $namespace = '';

                // Extract namespace
                if (preg_match('/namespace\s+([^;]+);/i', $class_code, $matches)) {
                    $namespace = trim($matches[1]);
                }

                $class = pathinfo($file, PATHINFO_FILENAME);
                //            $classname = 'app\database\migrations\\'.$class;
                $classname = $namespace . '\\' . $class;
                $instance = new $classname();
                $table = $instance->up();
                $this->Model->getConnection()->exec($table);
                $this->storeMigrationTable($class);
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