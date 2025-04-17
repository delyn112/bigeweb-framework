<?php
    namespace Bigeweb\App\Models;
    use illuminate\Support\Models\model;
    
    class ActivationModel extends model
    {
    
        protected $table = 'activations';
        
        
        public function getTableName()
        {
            return $this->table;
        }
    }