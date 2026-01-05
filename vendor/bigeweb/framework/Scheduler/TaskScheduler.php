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
    public function addSchedule($paramTask)
    {

        $this->task[] = [
            "task" => $paramTask,
            "interval" => null,
            "currentTime" => null,
            "lastRun" => null,
            "nextRun" => null,
        ];
        return($this);
    }


    public function runTaskScheduler()
    {
        $cronJobFile = dirname(__DIR__, 4).DIRECTORY_SEPARATOR.'cronjob'.DIRECTORY_SEPARATOR.'task.json';
        $now = time();
        $contentArray = [];
        if(file_exists($cronJobFile))
        {
            $content = file_get_contents($cronJobFile);
            if($content)
            {
                $contentArray = json_decode($content, true);
                // check if the saved json is lesser than the original array
                //then add the new commands to the array json
                if(count($contentArray) < count($this->task))
                {
                    foreach ($this->task as $key => $task)
                    {
                        if(!isset($contentArray[$key]) || $contentArray[$key]['task'] != $this->normalizeTask($task['task']))
                        {
                            $contentArray[$key] = $task;
                        }
                    }
                }elseif(count($contentArray) > count($this->task))
                {
                    if (count($contentArray) > count($this->task)) {
                        if (!unlink($cronJobFile)) {
                            // Handle error, e.g., log failure
                            error_log("Failed to delete cron job file: $cronJobFile");
                        }
                        $contentArray = [];
                    }
                }
            }
        }else{
            $contentArray = $this->task;
        }


        if(is_array($contentArray) && !empty($contentArray))
        {
            foreach ($contentArray as $key => $task)
            {
                if ($task['lastRun'] === null || ($now - $task['lastRun']) >= $task['interval']){
                    if(isset($task['task']) && class_exists($this->normalizeTask($task['task'])))
                    {
                        $instance = new $task['task']();
                        if(method_exists($instance, 'handle')){
                            $instance->handle();
                        }
                        $contentArray[$key]['task'] = get_class($instance);
                    }
                    $contentArray[$key]['lastRun'] = $now;
                    $contentArray[$key]['nextRun'] = $now + $task['interval'];
                }
            }
        }
        file_put_contents($cronJobFile, json_encode($contentArray));
    }

    public function normalizeTask($task)
    {
        if (is_string($task)) {
            $task = new $task();
        }
            return get_class($task);
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