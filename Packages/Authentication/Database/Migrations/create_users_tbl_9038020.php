<?php

namespace Bigeweb\Authentication\Database\Migrations;

class create_users_tbl_9038020
{
    public function up()
    {
        return "CREATE TABLE `users` (
            id int(11) NOT NULL AUTO_INCREMENT,PRIMARY KEY (`id`),
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
            created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
    }

    /**
     * @return string
     *
     *
     *
     */
    public function down(){
        return "drop table users";
    }

}