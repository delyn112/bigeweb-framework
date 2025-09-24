<?php

namespace illuminate\Support\Database;

trait JointQueryBuilder
{

    protected $jointClause = [];
    protected $jointTableClause = [];
    protected $selectClause = [];


    public function leftjoin(string $table_name, mixed $primary_key_table, mixed $foreign_key_table)
    {
        $this->jointClause[] = " LEFT JOIN $table_name ON $primary_key_table = $foreign_key_table";
        $this->jointTableClause[] = $table_name.".*";
        return $this;
    }

    public function rightjoin(string $table_name, mixed $primary_key_table, mixed $foreign_key_table)
    {
        $this->jointClause[] = " RIGHT JOIN $table_name ON $primary_key_table = $foreign_key_table";
        $this->jointTableClause[] = $table_name.".*";
        return $this;
    }

    public function crossjoin(string $table_name, mixed $primary_key_table, mixed $foreign_key_table)
    {
        $this->jointClause[] = " CROSS JOIN $table_name ON $primary_key_table = $foreign_key_table";
        $this->jointTableClause[] = $table_name.".*";
        return $this;
    }

    public function innerjoin(string $table_name, mixed $primary_key_table, mixed $foreign_key_table)
    {
        $this->jointClause[] = " INNER JOIN $table_name ON $primary_key_table = $foreign_key_table";
        $this->jointTableClause[] = $table_name.".*";
        return $this;
    }

    public function select(mixed $value)
    {
        $argument = func_get_args();
        $argument_params = implode(' , ', $argument);
        $this->selectClause[] = $argument_params;
        return $this;
    }
}