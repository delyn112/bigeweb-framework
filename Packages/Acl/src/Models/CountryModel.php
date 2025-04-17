<?php
    namespace Bigeweb\Acl\Models;
    use illuminate\Support\Models\model;

    class CountryModel extends model
    {
    
        protected $table = 'countries';
        
        
        public function getTableName()
        {
            return $this->table;
        }
    }