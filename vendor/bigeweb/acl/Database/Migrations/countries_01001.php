<?php
namespace Bigeweb\Acl\Database\Migrations;

class countries_01001{

    public function up()
    {
         $query = "CREATE TABLE IF NOT EXISTS `countries` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `phone` int(55) NOT NULL,
                `code` varchar(255) NOT NULL,
                `name` varchar(255) NOT NULL,
                PRIMARY KEY (`id`),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";

         return $query;
    }

    public function down()
    {
        $query = "DROP TABLE activations";
        return ($query);
    }
}

?>