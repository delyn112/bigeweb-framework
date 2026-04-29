<?php

namespace illuminate\Support\Models;

use illuminate\Support\Database\DBaction;
use illuminate\Support\Database\DbConnection as database;
use illuminate\Support\Database\DestroyBuilder;
use illuminate\Support\Database\DestroyQueryBuilder;
use illuminate\Support\Database\FinderQuery;
use illuminate\Support\Database\InsertQueryBuilder;
use illuminate\Support\Database\Paginator;
use illuminate\Support\Database\QueryBuilder;
use illuminate\Support\Database\JointQueryBuilder;

class Model
{
    use database;
    use InsertQueryBuilder;

    /**
     * @param $method
     * @param $args
     * @return mixed
     *
     */
    public static function __callStatic($method, $args)
    {
        return static::query()->$method(...$args);
    }


    public function __call($method, $args)
    {
        return static::query()->$method(...$args);
    }

    /**
     * @return EloquentQueryBuilder
     *
     */
    public static function query(string $query = null)
    {
        $self = new static();
        if($query)
        {
            $self->defaultQueryString = $query;
        }
        return new EloquentQueryBuilder($self);
    }


    /**
     * @return object|\PDO|null
     *
     */
    public function getConnection()
    {
        /**
         *
         * return the pdo connection
         */
        return $this->pdoConnection;
    }


    /**
     * @return mixed|string|null
     */
    public function table()
    {
        return $this->table;
    }

    /**
     * @return bool|mixed
     *
     */
    public function hasSoftDelete()
    {
        return $this->hasSoftDelete;
    }


    /**
     * @return string|null
     *
     */
    public function defaultQueryString()
    {
        return $this->defaultQueryString;
    }
}