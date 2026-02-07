<?php

namespace illuminate\Support\Database\Seeders;

use illuminate\Support\Database\DbConnection;


abstract class Seeder
{

    use DbConnection;

    abstract public function run(): void;

    protected function call(array $seeders): void
    {
        foreach ($seeders as $seeder) {
            (new $seeder)->run();
        }
    }

}