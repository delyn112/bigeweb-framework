<?php

namespace illuminate\Support\Facades;

class Storage
{
    public static function makeStorage($path)
    {
        if ($path) {
            if (!is_dir(asset('storage/public/' . $path))) {
                mkdir(asset('storage/public/' . $path), 0755, true);
            }
            $storagePath = 'storage/public/' . $path . '/';
        } else {
            $storagePath = 'storage/public/' . $path . '/';
        }

        return $storagePath;
    }


    public static function storeAs($path, $file, $name, $item = null)
    {
        $destination_path = asset('public' . DIRECTORY_SEPARATOR . $path) . $name;
        //check if the images are in array format
        //Then loop through and store else store as single

        if (!is_dir(asset('public' . DIRECTORY_SEPARATOR . $path))) {
            mkdir(asset('public/' . $path), 0755, true);
        }


        if ($item !== null) {
            move_uploaded_file($file['tmp_name'][$item], $destination_path);
        } else {
            move_uploaded_file($file['tmp_name'], $destination_path);
        }


    }
}