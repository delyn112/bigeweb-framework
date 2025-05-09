<?php

return [
    /*
   |--------------------------------------------------------------------------
   | Default Database Connection Name
   |--------------------------------------------------------------------------
   |
   | Here you may specify which of the database connections below you wish
   | to use as your default connection for all database work. Of course
   | you may use many connections at once using the Database library.
   |
   */

    'default' => env('DB_CONNECTION', 'mysql'),
    /*
       |--------------------------------------------------------------------------
       | Database Connections
       |--------------------------------------------------------------------------
       |
       | Here are each of the database connections setup for your application.
       | Of course, examples of configuring each database platform that is
       | supported by Laravel is shown below to make development simple.
       |
       |
       | All database work in Laravel is done through the PHP PDO facilities
       | so make sure you have the driver for your particular database of
       | choice installed on your machine before you begin development.
       |
       */

    'connections' => [

        'mysql' => [
            'DB_HOST' => env('DB_HOST', 'localhost'),
            'DB_PORT' => env('DB_PORT', '3306'),
            'DB_NAME' => env('DB_NAME', 'database'),
            'DB_USERNAME' => env('DB_USERNAME', 'root'),
            'DB_PASSWORD' => env('DB_PASSWORD', ''),
        ],
        ],

        /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */
    'migrations' => [
        'database/migrations'
    ]
];