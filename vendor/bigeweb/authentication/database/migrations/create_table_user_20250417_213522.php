<?php
    namespace Bigeweb\Authentication\database\migrations;
    
    class create_table_user_20250417_213522
    {
    
     /**
     * @return void
     *
     * Use to load the  migration
     */
 
 
        public function up()
        {
            return "CREATE TABLE IF NOT EXISTS users (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
            firstname varchar(255) NULL,
            lastname varchar(255)  NULL,
            email varchar(255)  NULL,
            token varchar(255)  NULL,
            password varchar(255)  NULL,
            username varchar(255)  NULL,
            usertype varchar(255)  NULL,
            banned enum('1', '0')  NULL DEFAULT '0',
            status enum('active', 'inactive', 'suspended', 'pending', 'closed')  NULL DEFAULT 'active',
            language VARCHAR(255) NULL,
            email_verified_at VARCHAR(255) NULL,
            force_email_verify VARCHAR(255) NULL,
             force_password_change VARCHAR(255) NULL,
            avatar VARCHAR(255) NULL,
            uuid VARCHAR(255) NULL,
            expiry_date VARCHAR(255) NULL,
            remember_me VARCHAR(255) NULL,
            deleted_at timestamp NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
 
        }
        
        
    /**
     * @return null
     *
     * Use to drop the database table
     * Reverse migration process
     */
        public function down()
        {
            return "DROP TABLE users";
        }
    }