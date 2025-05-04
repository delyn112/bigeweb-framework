<?php

namespace Bigeweb\App\Consoles;

use Bigeweb\App\Consoles\Commands\TransferDBCommand;
use illuminate\Support\Scheduler\TaskScheduler;

class RunCommands extends  TaskScheduler
{

    public function schedule()
    {
        $this->addSchedule((new TransferDBCommand()))->everyMinutes();
    }



    public function boot()
    {
        $this->schedule();
        $this->runTaskScheduler();
    }
};
