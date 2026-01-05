<?php

namespace illuminate\Support\Database;

trait QueryBuilder
{
    protected $queryLimit;
    protected $whereClause = [];
    protected $orwhereClause = [];
    protected $orderbyClause;
    protected $groupbyClause;

    public function query(mixed $queryString)
    {
        if($queryString != null)
        {
            $this->defaultQueryString = $queryString;
        }

        return ($this);
    }



    public function get()
    {
        return $this->executeQuery();
    }


    public function all()
    {
        return $this->executeQuery();
    }

    public function limit(int $limit, $offset = 0)
    {
        $this->queryLimit = " Limit ".$limit." OFFSET ".$offset;
        return $this;
    }

    public function where(string $column, mixed $operator, mixed $value)
    {
        if(!empty($column) && !empty($value))
        {
            $this->whereClause[] = "$column $operator '$value'";
        }

        return $this;
    }

    public function orwhere(string $column, mixed $operator, mixed $value)
    {
        if(!empty($column) && !empty($value))
        {
            $this->orwhereClause[] = "$column $operator '$value'";
        }

        return $this;
    }

    public function orderby(string $column, string $order)
    {
        $this->orderbyClause = " ORDER BY $column $order";
        return $this;
    }

    public function groupby(string $value)
    {
        $this->groupbyClause = " GROUP BY $value";
        return $this;
    }
}