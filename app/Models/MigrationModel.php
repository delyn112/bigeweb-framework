<?php
    namespace Bigeweb\App\Models;
    use illuminate\Support\Models\model;
    
    class MigrationModel extends model
    {
    
        protected $table = 'migrations';
        
        
        public function getTableName()
        {
            return $this->table;
        }
    }