<?php

namespace illuminate\Support\Database;


use illuminate\Support\Facades\Config;

trait DbConnection
{

    protected ?string $db_host = null;
    protected ?string $db_name = null;
    protected ?string $db_username = null;
    protected ?string $db_password = null;
    protected ?string $db_port = null;

    protected $table = null;
    protected ?string $defaultQueryString;
    protected ?array $fillable = [];

    public ?string $connectionType;
    protected ?object $pdoConnection;

    public function __construct()
    {
        $databaseFile = (object)Config::get('database');

        /**
         * throw exception if the config file is not found
         *
         */
        if (!$databaseFile) {
            throw new \Exception("database configuration file not found!. Contact support for assistance.");
        }

        /**
         *
         * set the default datbase as the main connection type
         */
        $this->connectionType = $databaseFile->default;


        /**
         * check if connection type if mysqli and make the connection
         *
         */

        switch ($this->connectionType) {
            case "sqlite" :
                $sqlPath = $databaseFile->connections[$this->connectionType]['storage_path'];
                /**
                 * create the storage folder if not in existence
                 *
                 */
                if (!is_dir($sqlPath)) {
                    mkdir($sqlPath, 0777);
                }

                $dbName = $sqlPath . '/' . $databaseFile->connections[$this->connectionType]['database'];
                /**
                 * Create the database
                 *
                 */
                $this->pdoConnection = new \PDO("sqlite:{$dbName}");
                break;
            case "mysql" :
            default :
                /**
                 * set the value of the database credentials
                 *
                 */

                $dbVariableArray = $databaseFile->connections[$this->connectionType];
                if (count($dbVariableArray) > 0) {
                    foreach ($dbVariableArray as $key => $value) {
                        $key = strtolower($key);
                        $this->$key = $value;
                    }
                }
                /**
                 *
                 * connect the database
                 */
                $dsn = sprintf(
                    "mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4",
                    $this->db_host,
                    $this->db_port ?? 3306,
                    $this->db_name
                );

                $this->pdoConnection = new \PDO($dsn,
                    $this->db_username,
                    $this->db_password,
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                        \PDO::ATTR_EMULATE_PREPARES => false,
                    ]);
                break;
        }

        /**
         *
         * get the file name and format it
         */
        $class = get_class($this);
        $split_class = explode("\\", $class);
        $myclass = end($split_class);
        $tableName = null;
            if (substr($myclass, -1) == 'y') {
                $tableName = substr_replace(strtolower($myclass), '', -1) . 'ies';
            } elseif (substr($myclass, -1) == 'f') {
                $tableName = substr_replace(strtolower($myclass), '', -1) . 'eves';
            } else {
                $tableName = strtolower($myclass) . 's';
            }

        /**
         * generate the table name if its not attached to model
         *
         */
            if(!$this->table)
            {
                $this->table = $tableName;
            }
        $this->defaultQueryString = "SELECT * from {$this->table}";
    }


    /**
     * @return object|\PDO|null
     *
     *
     */

    public function tryConnection() : ?object
    {
        return $this->pdoConnection;
    }


    /**
     * @return object|\PDO|null
     *
     */
    public function connect() : ?object
    {
        return $this->pdoConnection;
    }


    /**
     *
     * Create the database table for the project;
     */
    public function createDatabase(string $name = null)
    {
        if ($name) {
            $query = "CREATE DATABASE IF NOT EXISTS $name";
            $this->tryConnection()->exec($query);
        } else {
            if ($this->db_name != '') {
                $query = "CREATE DATABASE IF NOT EXISTS $this->db_name";
                $this->tryConnection()->exec($query);
            }
        }
    }


    /**
     * @return void
     *
     */
    public function dropDatabase()
    {
        $query = "DROP DATABASE $this->db_name";
        $this->tryConnection()->exec($query);
    }

}

?>