<?php
namespace illuminate\Support\Models;
use illuminate\Support\Database\DbConnection as database;
use illuminate\Support\Requests\Kennel;


class model
{
    use database;

    protected $statement;

    public function getConnection()
    {
        return $this->connect();
    }


    public function query($query)
    {
        if($this->getConnection() !== null)
        {
            $this->statement = $this->getConnection()->prepare($query);
            $this->statement->execute();
            return ($this);
        }else{
            return redirect(route('install-system'));
        }
    }

    public function all()
    {
        $query = $this->query("SELECT * FROM $this->table");
        return ($this->get());
    }

    public function get()
    {
        if($this->statement === null) {
            return $this->all();
        }
        return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function first()
    {
        $data = array_reverse($this->get());
        return array_pop($data);
    }


    public function find(string $column, mixed $value)
    {
        $result = $this->query("select * from $this->table WHERE $column = '$value'")
            ->first();
        return ($result);
    }

    public function findAll(string $column, mixed $value)
    {
        $result = $this->query("select * from $this->table WHERE $column = '$value'")
            ->get();
        return ($result);
    }

    public function findOrfail(string $column, mixed $value)
    {
        $result = $this->query("select * from $this->table WHERE $column = '$value'")
            ->first();

        if(!$result)
        {
            http_response_code(400);
        }
        return ($result);
    }


    public function save($param)
    {
        $data = [];
        foreach($param as $key => $value)
        {
            if($value != '')
            {
                $data[$key] = $value;
            }
        }

        $key = implode(",", array_keys($data));
        $value =  implode(',', array_map(fn($myvalue) => "'$myvalue'", $data));

        $query = "INSERT INTO $this->table ($key) VALUES (".$value.")";
        $this->getConnection()->exec($query);



        $query = $this->query("SELECT * from $this->table ORDER BY id DESC LIMIT 1");
        $result = $query->first();
        return ($result);
    }


    public function update($id, $param)
    {
        $updates = [];
        foreach ($param as $key => $value) {
                $updates[] = "$key = '$value'";
        }
        $updateString = implode(', ', $updates);

        $query = "UPDATE $this->table SET $updateString WHERE id = '$id'";
        $this->getConnection()->exec($query);

    }


    public function destroy($column, $id)
    {
        $query = "DELETE from $this->table where $column='$id'";
        return $this->getConnection()->exec($query);
    }
}

?>