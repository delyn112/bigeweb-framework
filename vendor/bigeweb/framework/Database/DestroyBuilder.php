<?php

namespace illuminate\Support\Database;

trait DestroyBuilder
{

    public function destroy($column, $id)
    {
        $query = "DELETE from $this->table where $column='$id'";
        return $this->getConnection()->exec($query);
    }
}