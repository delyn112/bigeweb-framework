<?php

namespace Bigeweb\App\Consoles\Commands;


class TransferDBCommand
{

    protected $signature = 'migrate:content';
    protected $description = 'Migrate old invoice database';

    public function handle()
    {
        file_put_contents('cron.txt', 'current date time is '.date('Y-m-d H:i:s'), FILE_APPEND.PHP_EOL);
    }
}