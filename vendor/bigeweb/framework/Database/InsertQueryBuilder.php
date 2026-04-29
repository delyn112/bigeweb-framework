<?php

namespace illuminate\Support\Database;

use illuminate\Support\Models\EloquentQueryBuilder;
use stdClass;
use function DDTrace\start_span;

trait InsertQueryBuilder
{

    /**
     * @param array $parameters
     * @return object|null
     *
     */
    public static function save(array $parameters = []) : ?object
    {
        $self = new static();
        $dataArray = [];

        if(count($self->fillable) > 0)
        {
            foreach($parameters as $key => $value)
            {
                if(in_array($key, $self->fillable))
                {
                    $dataArray[$key] = $value;
                }
            }
            $parameters = $dataArray;
        }

        if (empty($parameters)) {
            throw new \InvalidArgumentException("No valid fillable fields were provided for update.");
        }

        // Prepare SQL parts
        $columns = array_keys($parameters);
        $placeholders = array_map(fn($key) => ":$key", $columns);

        $query = "INSERT INTO {$self->table} (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $self->getConnection()->prepare($query);

        // Bind values
        foreach ($parameters as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $response = $stmt->execute();
        $lastInsertId = $self->getConnection()->lastInsertId();
        //return the last element saved
        return $self->find($lastInsertId);
    }



    /**
     * @param int|null $id
     * @param array|null $parameters
     * @return object|mixed|null
     *
     */
    public static  function  update(int $id, array $parameters = []) : ?object
    {
        $dataArray = [];
        $self = new static();
        if(count($self->fillable) > 0)
        {
            foreach($parameters as $key => $value)
            {
                if(in_array($key, $self->fillable))
                {
                    $dataArray[$key] = $value;
                }
            }
            $parameters = $dataArray;
        }


        if (empty($parameters)) {
            throw new \InvalidArgumentException("No valid fillable fields were provided for update.");
        }

        $fields = [];
        foreach($parameters as $key => $value)
        {
            $fields[] = "$key = :$key";
        }

        $updateString = implode(', ', $fields);

        $query = "UPDATE {$self->table} SET {$updateString} WHERE id = :id";
        $stmt = $self->getConnection()->prepare($query);

        foreach ($parameters as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $self->find($id);
    }



    /**
     * @param array $parameters
     * @param array $cond
     * @return object|\illuminate\Support\Models\Model|mixed|null
     *
     */
    public static function  updateOrcreate(array $parameters = [], array $attributes = []) : ?object
    {
        if (!is_array($parameters) || !is_array($attributes)) {
            throw new \InvalidArgumentException("updateOrCreate() both argument must be an array.");
        }

        $existingRecord = static::query()->where($attributes)->first();
        if (!$existingRecord) {
            return self::save($parameters);
        }
        return self::update($existingRecord->id, $parameters);
    }
}