<?php

namespace illuminate\Support\Facades;

class Storage
{

    /**
     * @param $path
     * @return string|null
     *
     */
    public static function makeStorage($path) : ?string
    {
        if ($path) {
            if (!is_dir(file_path('public/attachments/' . $path))) {
                mkdir(file_path('public/attachments/' . $path), 0777, true);
            }
            $storagePath = 'public/attachments/' . $path . '/';
        } else {
            $storagePath = 'public/attachments/' . $path . '/';
        }

        return $storagePath;
    }


    /**
     * @param $file
     * @param string|null $path
     * @param string|null $name
     * @return string|null
     *
     */
    public static function storeAs($file, ?string $path, ?string $name) : ?string
    {
        $destination_path = file_path('public/attachments/' . $path) .'/'. $name;
        //check if the images are in array format
        //Then loop through and store else store as single

        $location = self::makeStorage($path);

        move_uploaded_file($file, $destination_path);

        $location = str_replace('storage/public/', '', rtrim($location, '/'));;
        return "$location/$name";
    }
}