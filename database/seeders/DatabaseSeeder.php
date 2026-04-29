<?php

namespace Database\Seeders;

use illuminate\Support\Database\Seeders\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * @return void
     *
     */
    public function run() : void
    {
         $this->call([
            ActivationSeeder::class
        ]);
    }
}