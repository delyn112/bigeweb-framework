<?php

namespace illuminate\Support\Models;

use illuminate\Support\Database\DBaction;
use illuminate\Support\Database\DbConnection as database;
use illuminate\Support\Database\DestroyBuilder;
use illuminate\Support\Database\FinderQuery;
use illuminate\Support\Database\InsertQuery;
use illuminate\Support\Database\Paginator;
use illuminate\Support\Database\QueryBuilder;
use illuminate\Support\Database\JointQueryBuilder;

class Model
{
    use database;
    use QueryBuilder;
    use DBaction;
    use Paginator;
    use JointQueryBuilder;
    use FinderQuery;
    use DestroyBuilder;
    use InsertQuery;


    public function getConnection()
    {
        return $this->connect();
    }
}