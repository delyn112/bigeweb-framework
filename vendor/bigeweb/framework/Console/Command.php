<?php

namespace illuminate\Support\Console;

use Bigeweb\Framework\Console\RunCommand;

abstract  class Command
{

    protected $frequency;
    // This method will be overridden by each command to define what the command does
   abstract public function handle();


    public function hourly()
    {
        $this->frequency = 'hourly';
        return $this; // Return the object to allow further chaining
    }

    public function everyMinute()
    {
        $this->frequency = 'everyMinute';
        return $this;
    }

    public function daily()
    {
        $this->frequency = 'daily';
        return $this;
    }

    public function weekly()
    {
        $this->frequency = 'weekly';
        return $this;
    }


    public function monthly()
    {
        $this->frequency = 'monthly';
        return $this;
    }



    public function yearly()
    {
        $this->frequency = 'yearly';
        return $this;
    }

    // Getter to return the frequency
    public function getFrequency()
    {
        return $this->frequency;
    }

    // Method to run the command
   public static function command(Command $command)
   {
       // Execute the command
       return $command->handle();
   }
}