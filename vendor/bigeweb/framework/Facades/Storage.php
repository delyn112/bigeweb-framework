<?php

namespace illuminate\Support\Facades;

class Storage
{
    public static function makeStorage($path)
    {
        if ($path) {
            if (!is_dir(file_path('storage/public/' . $path))) {
                mkdir(file_path('storage/public/' . $path), 0755, true);
            }
            $storagePath = 'storage/public/' . $path . '/';
        } else {
            $storagePath = 'storage/public/' . $path . '/';
        }

        return $storagePath;
    }


    public static function storeAs($file, ?string $path, ?string $name)
    {
        $destination_path = file_path('public' . DIRECTORY_SEPARATOR . $path) .DIRECTORY_SEPARATOR. $name;
        //check if the images are in array format
        //Then loop through and store else store as single

        if (!is_dir(file_path('public' . DIRECTORY_SEPARATOR . $path))) {
            mkdir(file_path('public/' . $path), 0755, true);
        }
        self::makeStorage($path);

        move_uploaded_file($file, $destination_path);

        return $path.DIRECTORY_SEPARATOR.$name;
    }
}