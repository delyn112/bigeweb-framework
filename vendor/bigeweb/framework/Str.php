<?php
namespace illuminate\Support;

class Str
{
    /**
     * 
     * Generate string
     */


     public static  function string_generator($length = null)
     {
        $str = random_bytes($length);
        $str = base64_encode($str);
        $str = str_replace(["+", "/", "="], "", $str);
        $str = substr($str, 0, $length);
        return($str);
     }

     /**
      * Generate random number
      */

      public static function number_generator($start , $stop)
      {
        $number = rand($start, $stop);
        return($number);
      }
}

?>