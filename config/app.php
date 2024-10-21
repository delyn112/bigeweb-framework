<?php
/**
 *
 * return the system constant variables
 */
return [
    /*
     * This section returns the system
     * requirement. Each system has their own constant requirement.
     *
     */
    'system_requirement' => [
        'mysqli',
        'gd',
        'pdo_mysql',
         'xsl',
        //'ioncube',
        'intl',
        'curl',
        'fileinfo',
    ],

   //System need a default time zone to run on,
    //In this case we are choosing our base which is
    //Kuala Lumpur Malaysia
    'timezone' =>'Asia/Kuala_Lumpur',

    //This holds the list of all our routes
    //Which will be accessed in this application
    'routesFrom' => [
        asset('routes'),
    ],
    //We also need to pen down where our migrations will be coming form.
    // Therefore we need to let the system knows how to handle each migrations
    'migrationsFrom' => [
        asset('database/migrations')
    ]
]

?>