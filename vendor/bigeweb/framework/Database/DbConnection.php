<?php
namespace illuminate\Support\Database;


use illuminate\Support\Facades\Config;

trait DbConnection
{

    protected $db_host;
    protected $db_name;
    protected $db_username;
    protected $db_password;
    protected $db_port;

    protected $connection;
    protected $table;
    protected $defaultQueryString;
    protected $fillable = [];

    public function __construct()
    {
        $variable = Config::get('database.connections');
        foreach($variable as $key => $variableConnection)
        {
           if($key === Config::get('database.default'))
           {
               foreach($variableConnection as $key => $connParam)
               {
                   if($connParam)
                   {
                      $keyParam = strtolower($key);
                       $this->$keyParam = $connParam;
                   }
               }
           }
        }
        $class = get_class($this);

        $split_class = explode("\\", $class);
        $myclass = end($split_class);
        if(!$this->table)
        {
            if(substr($myclass, -1) == 'y'){
                $this->table = substr_replace( strtolower($myclass), '', -1).'ies';
            }elseif(substr($myclass, -1) == 'f')
            {
                $this->table = substr_replace( strtolower($myclass), '', -1).'eves';
            }else{
                $this->table = strtolower($myclass).'s';
            }
        }

        $this->defaultQueryString = "SELECT * from $this->table";
    }


    public function tryConnection()
    {
        $sqlData = "mysql:host=$this->db_host";
       try{
           $conn = new \PDO($sqlData, $this->db_username , $this->db_password);
           //  set the PDO error mode to exception
           $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
           return $conn;
       }catch (\Exception $e)
       {
           file_put_contents('error.log', $e->getMessage(), FILE_APPEND);
       }
    }

    public function connect()
    {
        if($this->db_name == null)
        {
            $sqlData = "mysql:host=$this->db_host";
            try{

                $this->connection = new \PDO($sqlData, $this->db_username, $this->db_password);
                //  set the PDO error mode to exception
                $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }catch (\Exception $e){}
        }else{
            $sqlData = "mysql:host=$this->db_host;dbname=$this->db_name";
            try{
                $this->connection = new \PDO($sqlData, $this->db_username, $this->db_password);
                //  set the PDO error mode to exception
                $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }catch (\Exception $e){
                file_put_contents('error.log', $e->getMessage(), FILE_APPEND);
            }
        }

        return  $this->connection;
    }



    /**
     *
     * Create the database table for the project;
     */
    public function createDatabase(string $name = null)
    {
            if($name)
            {
                    $query = "CREATE DATABASE IF NOT EXISTS $name";
                    $this->tryConnection()->exec($query);
            }else{
                if ($this->db_name != '') {
                    $query = "CREATE DATABASE IF NOT EXISTS $this->db_name";
                    $this->tryConnection()->exec($query);
                }
            }
    }


    public function dropDatabase()
{
    $query = "DROP DATABASE $this->db_name";
    $this->tryConnection()->exec($query);
}

}
?>