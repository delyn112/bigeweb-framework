<?php

namespace illuminate\Support\Dotenv;


use illuminate\Support\Dotenv\Exceptions\FileNotFoundException;
use illuminate\Support\Dotenv\Exceptions\MissingKeyException;

class Dotenv
{
    protected $get;
    protected $put;
    protected $delete;
    protected $value = null;

    public function __construct()
    {
    }

    public function getFilePath()
    {
        return $envFile =getPath().'/.env';
    }

    public static function env(string $keyParam = null, $defaultValue = null)
    {
        $self = new self();
        if($keyParam === null)
        {
            file_put_contents('error.log', "Encounter an error please input key and try again!");
            MissingKeyException::keyMissing();
        }

        if($defaultValue !== null)
        {
            $self->value = $defaultValue;
        }

        $envFile = $self->getFilePath();
        if(file_exists($envFile))
        {
            try {
                $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach($lines as $line)
                {
                    // Skip comments and whitespace
                    if (strpos(trim($line), '#') === 0) {
                        continue;
                    }

                    //split the key and value
                    $lineArray = explode('=', $line);
                    if(count($lineArray) > 0)
                    {
                        $key = $lineArray[0] ? trim($lineArray[0]) : null;
                        if($key == trim($keyParam))
                        {
                            $value = $lineArray[1] ? trim($lineArray[1]) : null;
                            $self->value = str_replace(['"', '\''], '', $value);
                        }
                    }
                }
                //send out the output
                return $self->value;
            }catch (Exception $e)
            {
                file_put_contents('error.log', $e->getMessage(), FILE_APPEND);
                FileNotFoundException::message($e->getMessage());
            }
        }else{
            $errorMessage = "$envFile not found in ".__DIR__;
            file_put_contents('error.log', $errorMessage, FILE_APPEND);
            FileNotFoundException::message($errorMessage);
        }
    }


    public static function putEnv(string $keyParam = null, mixed $value = null)
    {
        $self = new self();
        $envFile = $self->getFilePath();

        if($keyParam !== null)
        {
            $text = $keyParam.'='.$value;
            file_put_contents($envFile , $text, FILE_APPEND);
        }
    }


    public static function deleteEnv(string $keyParam = null)
    {
        $newFileArray = [];
        if($keyParam !== null)
        {
            $keyParam = trim($keyParam);
        }
        $self = new self();
        if(file_exists($self->getFilePath()))
        {
            //$fileContents = file_get_contents($self->getFilePath());
            $fileContents = file($self->getFilePath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if(count($fileContents) > 0)
            {

                foreach($fileContents as $line)
                {
                    //get the key and value
                    $splitToArray = explode('=', $line);
                   $key = $splitToArray[0] ? trim($splitToArray[0]) : null;

                   if($key !== $keyParam)
                   {
                       if (strpos(trim($key), '#') === 0) {
                           $newFileArray[] = PHP_EOL.PHP_EOL.$line.PHP_EOL;
                       }else{
                           $newFileArray[] = $line.PHP_EOL;
                       }
                   }
                }
                file_put_contents($self->getFilePath(), $newFileArray);
            }
        }
    }
}