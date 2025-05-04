<?php

namespace illuminate\Support\Scheduler;

use Carbon\Carbon;
use illuminate\Support\Console\Command;

class TaskScheduler
{

    protected array $task = [];

    public function addSchedule($task)
    {
        $this->task[] = [
            "task" => $task,
            "interval" => null,
            "runCompleted" => null
        ];

        return $this;
    }


    public function runTaskScheduler()
    {
        if (count($this->task) > 0) {
            foreach ($this->task as $key => $task) {
                $taskInstance = $task["task"];
                $taskInterval = $task["interval"];
                $completedTask = $task["runCompleted"];
                $currentTime = time();  // Current Unix timestamp

                // If the task has not run before or the interval has passed
                if ($completedTask === null || $currentTime - $completedTask >= $taskInterval) {
                    if (isset($taskInstance) && class_exists(get_class($taskInstance))) {
                        // Check if the method 'handle' exists and run it
                        if (method_exists($taskInstance, 'handle')) {
                            $taskInstance->handle();
                        }
                    }

                    // Update the time of the last completed task
                    $this->task[$key]["runCompleted"] = $currentTime;
                }
            }
        }
    }

    public function everyMinutes()
    {
        $this->task[count($this->task) - 1]["interval"] = 60;  // 1 minute in seconds
        return $this;
    }

    public function every30Minutes()
    {
        $this->task[count($this->task) - 1]["interval"] = 30 * 60;  // 30 minutes in seconds
        return $this;
    }

    public function everyHour()
    {
        $this->task[count($this->task) - 1]["interval"] = 60 * 60;  // 1 hour in seconds
        return $this;
    }

    public function everyDay()
    {
        $this->task[count($this->task) - 1]["interval"] = 24 * 60 * 60;  // 1 day in seconds
        return $this;
    }

    public function everyMonth()
    {
        $this->task[count($this->task) - 1]["interval"] = 30 * 24 * 60 * 60;  // 1 month (approx 30 days) in seconds
        return $this;
    }

    public function everyYear()
    {
        $this->task[count($this->task) - 1]["interval"] = 365 * 24 * 60 * 60;  // 1 year in seconds (approx 365 days)
        return $this;
    }



}