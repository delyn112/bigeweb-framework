<?php

namespace Bigeweb\App\Consoles;

use Bigeweb\App\Consoles\Commands\TransferDBCommand;
use illuminate\Support\Scheduler\TaskScheduler;

class RunCommands extends  TaskScheduler
{

    public function schedule()
    {
        $this->addSchedule((new TransferDBCommand()))->everyFiveMinutes();
    }



    public function boot()
    {
        $this->schedule();
        $this->runTaskScheduler();
    }
};
