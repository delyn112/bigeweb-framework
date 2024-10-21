<?php

namespace app\database\migrations;

class migration_001
{
    /**
     * This function helps to create the database table
     */
    public function up()
    {
        $query = "CREATE TABLE IF NOT EXISTS migrations (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
           migration varchar(255) NULL,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        return ($query);
    }

    /**
     * 
     * 
     * This function helps to drop the database table
     */

    public function down()
    {
        return "DROP TABLE migrations";
    }
}

?>