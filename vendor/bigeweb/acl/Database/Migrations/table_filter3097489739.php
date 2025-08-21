<?php
namespace Bigeweb\Acl\Database\Migrations;

class table_filter3097489739
{

    public function up()
    {
        $query = "CREATE TABLE IF NOT EXISTS table_filters (
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                filter_title VARCHAR(255) NULL,
                method LONGTEXT NULL,
                token VARCHAR(255) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";

        return $query;
    }


    public function down()
    {
        return "DROP TABLE table_filters";
    }
}