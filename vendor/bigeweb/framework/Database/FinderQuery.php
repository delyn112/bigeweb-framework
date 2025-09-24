<?php

namespace illuminate\Support\Database;

trait FinderQuery
{

    public function first()
    {
        $data = $this->executeQuery();
        $get_last_content = array_reverse($data);
        return array_pop($get_last_content);
    }

    public function find(string $column, mixed $value)
    {
        $this->defaultQueryString = "SELECT * FROM $this->table WHERE $column = '$value'";
        return $this->first();
    }

    public function findAll(string $column, mixed $value)
    {
        $this->defaultQueryString = "SELECT * FROM $this->table WHERE $column = '$value'";
        return $this->get();
    }

    public function findOrfail(string $column, mixed $value)
    {
        $result = $this->find($column, $value);

        if(!$result)
        {
            http_response_code(400);
        }
        return ($result);
    }


}