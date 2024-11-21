<?php

namespace illuminate\Support\Database;

trait DBaction
{
    protected $statement;

    public function executeQuery()
    {
        if($this->getConnection() !== null)
        {
            $this->statement = $this->mergeQuery();
            $this->statement = $this->getConnection()->prepare($this->statement);
                $this->statement->execute();
            return $this->statement->fetchAll(\PDO::FETCH_OBJ);
        }

        log_Error("No connection to database");
        throw new \Exception("No connection to database");
    }

    /**
     * Resets the query-related properties to their default states.
     */
    protected function resetQueryState()
    {
        $this->selectClause = [];
        $this->jointClause = [];
        $this->whereClause = [];
        $this->orwhereClause = [];
        $this->groupbyClause = '';
        $this->orderbyClause = '';
        $this->queryLimit = '';
        $this->defaultQueryString = '';
    }



    public function mergeQuery()
    {
        if(!empty($this->jointClause))
        {
            //check if the user has select option
            if(!empty($this->selectClause))
            {
                $select_stmt = implode(', ', $this->selectClause);
            }else{
                //if the user doest have any select preference
                //select all data from db
                $select_stmt = implode(', ', $this->jointTableClause);
                $select_stmt .= ", $this->table.*";
            }
            $this->defaultQueryString = "SELECT $select_stmt FROM $this->table";
            $this->defaultQueryString .= implode(' ', $this->jointClause);
        }else{
            if(!empty($this->selectClause))
            {
                $select_stmt = implode(', ', $this->selectClause);
                $this->defaultQueryString = "SELECT $select_stmt FROM $this->table";
            }
        }


        if($this->whereClause != null)
        {
          $this->defaultQueryString .= " WHERE ".implode(' AND ', $this->whereClause);
        }

        if($this->orwhereClause != null)
        {
            if(!(empty($this->whereClause)) && count($this->whereClause) > 0)
            {
                $this->defaultQueryString .= " OR ".implode(' OR ', $this->orwhereClause);
            }else{
                $this->defaultQueryString .= " WHERE ".implode(' OR ', $this->orwhereClause);
            }
        }

        if(!empty( $this->groupbyClause))
        {
            $this->defaultQueryString .= $this->groupbyClause;
        }

        if(!empty($this->orderbyClause))
        {
            $this->defaultQueryString .= $this->orderbyClause;
        }

        if(!empty($this->queryLimit))
        {
            $this->defaultQueryString .= $this->queryLimit;
        }

        return $this->defaultQueryString;
    }
}