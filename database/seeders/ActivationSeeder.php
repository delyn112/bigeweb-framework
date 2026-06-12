<?php

namespace Database\Seeders;

use illuminate\Support\Database\Seeders\Seeder;

class ActivationSeeder extends  Seeder
{

    /**
     * @return void
     *
     */
    public function run() : void
    {
        $this->connect()->exec("INSERT INTO activations (created_at)
        VALUES (now())");
    }

}