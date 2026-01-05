<?php

namespace illuminate\Support\Facades;

class Storage
{
    public static function makeStorage($path)
    {
        if ($path) {
            if (!is_dir(file_path('storage/public/attachments/' . $path))) {
                mkdir(file_path('storage/public/attachments/' . $path), 0755, true);
            }
            $storagePath = 'storage/public/attachments/' . $path . '/';
        } else {
            $storagePath = 'storage/public/attachments/' . $path . '/';
        }

        return $storagePath;
    }


    public static function storeAs($file, ?string $path, ?string $name)
    {
        $destination_path = file_path('public/attachments/' . $path) .'/'. $name;
        //check if the images are in array format
        //Then loop through and store else store as single

        if (!is_dir(file_path('public/attachments/' . $path))) {
            mkdir(file_path('public/attachments/' . $path), 0755, true);
        }
        $location = self::makeStorage($path);

        move_uploaded_file($file, $destination_path);

        $location = str_replace('storage/public/', '', rtrim($location, '/'));;
        return "$location/$name";
    }
}