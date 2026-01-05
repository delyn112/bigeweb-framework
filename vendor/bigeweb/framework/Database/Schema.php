<?php

namespace illuminate\Support\Database;

class Schema
{
    public static function create(string $tableName, \Closure $callback)
    {
        $blueprint = new TableBlueprint($tableName);
        $callback($blueprint);

        $sql = $blueprint->toSql();
        $pdo = $blueprint->connect(); // or however you store PDO
        $pdo->exec($sql);
    }


    public static function drop(string $tableName)
    {
        $blueprint = new TableBlueprint($tableName);

        $sql = $blueprint->down();
        $pdo = $blueprint->connect(); // or however you store PDO
        $pdo->exec($sql);
    }
}