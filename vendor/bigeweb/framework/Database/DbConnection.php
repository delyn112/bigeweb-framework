<?php
namespace illuminate\Support\Database;


trait DbConnection
{

    protected $host= DB_HOST;
    protected $dbname= DB_NAME;
    protected $username= DB_USERNAME;
    protected $password= DB_PASSWORD;
    protected $db_port = DB_PORT;

    protected $connection;
    protected $table;
    protected $defaultQueryString;

    public function __construct()
    {
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
        $sqlData = "mysql:host=$this->host";
       try{
           $conn = new \PDO($sqlData, $this->username , $this->password);
           //  set the PDO error mode to exception
           $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
           return $conn;
       }catch (\Exception $e)
       {
           return false;
       }
    }

    public function connect()
    {
        if(DB_NAME == null)
        {
            $sqlData = "mysql:host=$this->host";
            try{

                $this->connection = new \PDO($sqlData, $this->username, $this->password);
                //  set the PDO error mode to exception
                $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }catch (\Exception $e){}
        }else{
            $sqlData = "mysql:host=$this->host;dbname=$this->dbname";
            try{
                $this->connection = new \PDO($sqlData, $this->username, $this->password);
                //  set the PDO error mode to exception
                $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }catch (\Exception $e){
                // dd($e->getMessage());
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
                if ($this->dbname != '') {
                    $query = "CREATE DATABASE IF NOT EXISTS $this->dbname";
                    $this->tryConnection()->exec($query);
                }
            }
    }


    public function dropDatabase()
{
    $query = "DROP DATABASE $this->dbname";
    $this->tryConnection()->exec($query);
}

}
?>