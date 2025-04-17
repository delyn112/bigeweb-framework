<?php
    namespace Bigeweb\Acl\database\migrations;
    
    class create_table_country_20250417_213136
    {
    
     /**
     * @return void
     *
     * Use to load the  migration
     */
 
 
        public function up()
        {
            return "CREATE TABLE IF NOT EXISTS countries (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
                `phone` int(55) NOT NULL,
                `code` varchar(255) NOT NULL,
                `name` varchar(255) NOT NULL,
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
            return "DROP TABLE countries";
        }
    }