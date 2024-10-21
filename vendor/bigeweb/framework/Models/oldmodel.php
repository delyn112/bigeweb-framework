<?php
namespace illuminate\Support\Models;
use illuminate\Support\Database\DbConnection as database;
use illuminate\Support\Requests\Kennel;
use illuminate\Support\Database\DBaction;


class model
{
    use database;
    use QueryBuilder;
    use DBaction;


        public function getConnection()
        {
            return $this->connect();
        }
}

//    protected $statement;
//
//    protected $limit = 0;
//    protected $offset = 0;
//    protected $whereClause = [];
//    protected $joinClause = [];
//    protected $joinTable = [];
//    protected $limitClause = '';
//    protected $selectClause= '';





//
//  public function query(mixed $param)
//  {
//      $this->dbquery = $param;
//      return $this;
//  }
//
//
////  public function get()
////  {
////      if($this->statement === null)
////        {
////            return $this->all();
////        }
////        return $this->execute();
////  }
//
//
//    public function all()
//    {
//        return $this->execute();
//    }
//
//    public function execute()
//    {
////        if(!empty($this->joinTable))
////        {
////            $implodedTable = implode(',', $this->joinTable);
////            $this->dbquery = "SELECT $implodedTable, $this->table.*";
////        }
////
////        if($this->selectClause)
////        {
////            $this->dbquery .= ", $this->selectClause";
////        }
////
////        if($this->selectClause || $this->joinClause)
////        {
////            $this->dbquery .= " FROM $this->table";
////        }
////
////        if (!empty($this->joinClause)) {
////            $this->dbquery .= " " . implode(" ", $this->joinClause);
////        }
////
////        if(!empty($this->whereClause))
////        {
////            $this->dbquery .= ' WHERE '.implode(' AND ', $this->whereClause);
////        }
////
////        dd($this->limitClause);
////        if(!empty($this->limitClause))
////        {
////            $this->dbquery .= $this->limitClause;
////        }
////
////        $this->statement = $this->dbquery;
////        if($this->getConnection() !== null)
////        {
////            $this->statement = $this->getConnection()->prepare($this->statement);
////                $this->statement->execute();
////            return $this->statement->fetchAll(\PDO::FETCH_OBJ);
////        }else{
////            return redirect(route('install-system'));
////        }
//    }
//
//    public function limit(int $limit, int $offset = 0)
//    {
////        $this->limitClause .= " LIMIT $limit OFFSET $offset";
////        return ($this);
//    }
//
//    public function paginate(int $number_of_row_per_pages, int $currentPage = 1)
//    {
////        $totalRows = $this->total_records();
////        $getTotalPages = ceil($totalRows/$number_of_row_per_pages);
////        if(isset($_GET['page']))
////        {
////            $currentPage = $_GET['page'];
////        }
////        $getOffset  = ($currentPage - 1) * $number_of_row_per_pages;
////
////        $this->dbquery .= " LIMIT $number_of_row_per_pages OFFSET $getOffset";
////        dd($totalRows);
////       return $this->get();
//    }
//
//    public function total_records()
//    {
//        $records = $this->execute();
//       return count($records);
//    }
//
//
//    public function paginationULR()
//    {
//        dd($this->statement);
//    }
//
//    public function orderby(string $column, mixed $type)
//    {
//        $this->dbquery .= " ORDER BY $column $type";
//        return ($this);
//    }
//
//    public function where($column, $operator, $value)
//    {
//       $this->whereClause[] = "$column $operator '$value'";
//        return $this;
//    }
//
//
//    public function orwhere($column, $operator, $value)
//    {
//        if (empty($this->whereClauses)) {
//            $this->whereClauses[] = "$column $operator '$value'";
//        } else {
//            $this->whereClauses[] = "OR $column $operator '$value'";
//        }
//        return $this;
//    }
//
//
//    public function select(string $param)
//    {
//        $this->selectClause = " SELECT $param";
//        return $this;
//    }
//
//    public function leftJoin(string $table, string $column1, string $column2)
//    {
//        $this->joinTable[] = $table.'.*';
//        $this->joinClause[] = "LEFT JOIN $table ON $column1 = $column2";
//        return $this;
//    }
//
//
//    public function rightjoin(string $table, string $column1, string $column2)
//    {
//        $this->joinClause[] = "RIGHT JOIN $table ON $column1 = $column2";
//        return $this;
//    }
//
//    public function innerjoin(string $table, string $column1, string $column2)
//    {
//        $this->joinClause[] = "INNER JOIN $table ON $column1 = $column2";
//        return $this;
//    }
//
//
//    public function fulljoin(string $table, string $column1, string $column2)
//    {
//        $this->joinClause[] = "FULL OUTER JOIN $table ON $column1 = $column2";
//        return $this;
//    }
//
//    public function first()
//    {
//        $data = array_reverse($this->get());
//        return array_pop($data);
//    }
//
//
//    public function find(string $column, mixed $value)
//    {
//        $result = $this->query("select * from $this->table WHERE $column = '$value'")
//            ->first();
//        return ($result);
//    }
//
//    public function findAll(string $column, mixed $value)
//    {
//        $result = $this->query("select * from $this->table WHERE $column = '$value'")
//            ->get();
//        return ($result);
//    }
//
//    public function findOrfail(string $column, mixed $value)
//    {
//        $result = $this->query("select * from $this->table WHERE $column = '$value'")
//            ->first();
//
//        if(!$result)
//        {
//            http_response_code(400);
//        }
//        return ($result);
//    }
//
//
//
//    public function save($param)
//    {
//        $data = [];
//        foreach($param as $key => $value)
//        {
//            if($value != '')
//            {
//                $data[$key] = $value;
//            }
//        }
//
//        $key = implode(",", array_keys($data));
//        $value =  implode(',', array_map(fn($myvalue) => "'$myvalue'", $data));
//
//        $query = "INSERT INTO $this->table ($key) VALUES (".$value.")";
//        $this->getConnection()->exec($query);
//
//
//
//        $query = $this->query("SELECT * from $this->table ORDER BY id DESC LIMIT 1");
//        $result = $query->first();
//        return ($result);
//    }
//
//
//    public function update($id, $param)
//    {
//        $updates = [];
//        foreach ($param as $key => $value) {
//                $updates[] = "$key = '$value'";
//        }
//        $updateString = implode(', ', $updates);
//
//        $query = "UPDATE $this->table SET $updateString WHERE id = '$id'";
//        $this->getConnection()->exec($query);
//
//        $query = $this->query("SELECT * from $this->table WHERE id='$id' ORDER BY id DESC LIMIT 1");
//        $result = $query->first();
//        return ($result);
//    }
//
//
//    public function destroy($column, $id)
//    {
//        $query = "DELETE from $this->table where $column='$id'";
//        return $this->getConnection()->exec($query);
//    }
//}

?>