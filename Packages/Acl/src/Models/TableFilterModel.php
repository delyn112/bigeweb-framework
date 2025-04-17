<?php
    namespace Bigeweb\Acl\Models;
    use illuminate\Support\Models\model;

    class TableFilterModel extends model
    {
    
        protected $table = 'table_filters';
        
        
        public function getTableName()
        {
            return $this->table;
        }
    }