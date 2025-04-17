<?php
    namespace Bigeweb\Authentication\Models;
    use illuminate\Support\Models\model;

    class AuthModel extends model
    {
    
        protected $table = 'users';
        
        
        public function getTableName()
        {
            return $this->table;
        }

        protected $filable = [
            "first_name",
            "last_name",
            "username",
            "email",
            "password",
            "token",
            "usertype",
            "status"
        ];
    }