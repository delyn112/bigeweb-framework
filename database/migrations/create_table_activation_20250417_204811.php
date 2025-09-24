<?php
    namespace Database\migrations;
    
    class create_table_activation_20250417_204811
    {
    
     /**
     * @return void
     *
     * Use to load the  migration
     */
 
 
        public function up()
        {
            return "CREATE TABLE IF NOT EXISTS activations (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
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
            return "DROP TABLE activations";
        }
    }