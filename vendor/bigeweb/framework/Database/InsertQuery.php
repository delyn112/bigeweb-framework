<?php

namespace illuminate\Support\Database;

trait InsertQuery
{

    public function save(array $parameter)
    {
        $data = [];

        // Filter allowed fields (if $fillable is set)
        foreach ($parameter as $key => $value) {
            if ($value !== '') {
                if (!empty($this->fillable)) {
                    if (in_array($key, $this->fillable)) {
                        $data[$key] = $value;
                    }
                } else {
                    $data[$key] = $value;
                }
            }
        }

        // Prepare SQL parts
        $columns = array_keys($data);
        $placeholders = array_map(fn($key) => ":$key", $columns);

        $query = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->getConnection()->prepare($query);

        // Bind values
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();

        // Fetch updated row
        $query = $this->query("SELECT * from $this->table ORDER BY id DESC LIMIT 1");
        $result = $query->first();
        return ($result);
    }


    public function update(int $id, array $parameter) : ?object
    {
        // Filter allowed fields (if $fillable is set)
        foreach ($parameter as $key => $value) {
            if ($value !== '') {
                if (!empty($this->fillable)) {
                    if (in_array($key, $this->fillable)) {
                        $data[$key] = $value;
                    }
                } else {
                    $data[$key] = $value;
                }
            }
        }



        $fields = [];
        foreach ($parameter as $key => $value) {
            $fields[] = "$key = :$key"; // Create placeholders
        }

        $updateString = implode(', ', $fields);
        $query = "UPDATE {$this->table} SET $updateString WHERE id = :id";

        $stmt = $this->getConnection()->prepare($query);

        // Bind values
        foreach ($parameter as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(':id', $id);
        $stmt->execute();

        // Fetch updated row
        $query = $this->query("SELECT * from $this->table WHERE id='$id' ORDER BY id DESC LIMIT 1");
        $result = $query->first();
        return ($result);

    }


    public function updateOrcreate(array $parameter, array $parameterValue) : ?object {
        $cond = [];
        $result = null;
        foreach ($parameterValue as $key => $value) {
            if(!is_null($value))
            {
                $cond[] = "$key ='".$value."'";
            }
        }

        if(count($cond) > 0) {
            $condition = implode(' AND ', $cond);
            $query = $this->query("SELECT * from $this->table WHERE {$condition}");
            $result = $query->first();
        }

        if(!$result)
        {
            //Create new task if not found
           return $this->save($parameter);
        }
        return  $this->update($result->id, $parameter);
    }
}