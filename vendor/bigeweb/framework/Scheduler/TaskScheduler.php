<?php

namespace illuminate\Support\Scheduler;

use Carbon\Carbon;
use illuminate\Support\Console\Command;

class TaskScheduler
{

    protected array $task = [];

    /**
     * @param $task
     * @return void
     *
     * Load all the task and add them to the task array
     */
    public function addSchedule($task)
    {
        $this->task[] = [
            "task" => $task,
            "interval" => null,
            "currentTime" => null,
            "lastRun" => null,
            "nextRun" => null,
        ];

        return($this);
    }


    public function runTaskScheduler()
    {
        if (count($this->task) > 0) {
            foreach ($this->task as $key => &$task) {  // Note the & here
                $now = time();
                if ($task['lastRun'] === null || ($now - $task['lastRun']) >= $task['interval']) {

                    if (isset($task['task']) && class_exists(get_class($task['task']))) {
                        if (method_exists($task['task'], 'handle')) {
                            $task['task']->handle();
                        }
                    }
                    $task['lastRun'] = $now;
                    $task['nextRun'] = $now + $task['interval'];
                }
            }
            unset($task);  // Break reference
        }
    }


    protected function setInterval(int $seconds)
    {
        $key = array_key_last($this->task); // safer for append
        $now = time();

        $this->task[$key]["interval"] = $seconds;
        $this->task[$key]["currentTime"] = $now;
        $this->task[$key]["nextRun"] = $now + $seconds;

        return $this;
    }

    public function everyMinutes()
    {
        return $this->setInterval(60);
    }

    public function everyFiveMinutes()
    {
        return $this->setInterval(5 * 60);
    }


    public function every30Minutes()
    {
        return $this->setInterval(30 * 60);
    }

    public function everyHour()
    {
        return $this->setInterval(60 * 60);
    }

    public function everyDay()
    {
        return $this->setInterval(24 * 60 * 60);
    }

    public function everyMonth()
    {
        return $this->setInterval(30 * 24 * 60 * 60);
    }

    public function everyYear()
    {
        return $this->setInterval(365 * 24 * 60 * 60);
    }

}