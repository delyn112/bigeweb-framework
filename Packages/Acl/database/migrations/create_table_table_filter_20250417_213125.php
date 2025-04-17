<?php
    namespace Bigeweb\Acl\database\migrations;
    
    class create_table_table_filter_20250417_213125
    {
    
     /**
     * @return void
     *
     * Use to load the  migration
     */
 
 
        public function up()
        {
            return "CREATE TABLE IF NOT EXISTS table_filters (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
                filter_title VARCHAR(255) NULL,
                method LONGTEXT NULL,
                token VARCHAR(255) NULL,
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
            return "DROP TABLE table_filters";
        }
    }