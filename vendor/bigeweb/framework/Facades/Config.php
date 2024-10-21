<?php

namespace illuminate\Support\Facades;


class Config
{

     public static function get(string $key)
     {
         try{
             $file = asset('config/'.$key.'.php');
             $file2 = asset($key.'.php');
             if(file_exists($file))
             {
                 $configFile = require $file;
             }elseif(file_exists($file2)){
                 $configFile = require $file2;
             }

             return $configFile;
         }catch(\Exception $e){
            return $e->getMessage();
        }

     }
}