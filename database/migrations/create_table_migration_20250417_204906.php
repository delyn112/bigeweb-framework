<?php
    namespace Database\migrations;
    
    class create_table_migration_20250417_204906
    {
    
     /**
     * @return void
     *
     * Use to load the  migration
     */
 
 
        public function up()
        {
            return "CREATE TABLE IF NOT EXISTS migrations (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
             migration varchar(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
 
        }
        
        
    /**
     * @return null
     *
     * Use to drop the database table
     */
        public function down()
        {
            return "DROP TABLE migrations";
        }
    }