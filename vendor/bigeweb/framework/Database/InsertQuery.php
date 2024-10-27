<?php

namespace illuminate\Support\Database;

trait InsertQuery
{

    public function save($param)
    {
        $data = [];
        foreach($param as $key => $value)
        {

                if($value != '')
                {
                    if(!empty($this->fillable))
                    {
                        isset($this->fillable[$key]) ?
                            $data[$key] = $value : null;
                    }else{
                        $data[$key] = $value;
                    }
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

        $query = $this->query("SELECT * from $this->table WHERE id='$id' ORDER BY id DESC LIMIT 1");
        $result = $query->first();
        return ($result);
    }
}