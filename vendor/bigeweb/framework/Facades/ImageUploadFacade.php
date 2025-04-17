<?php

namespace illuminate\Support\Facades;
use illuminate\Support\Facades\Storage;

class ImageUploadFacade
{
    public function upload_image($request, $file, $path)
    {
        $filename = $file['name'];
        $destination = Storage::makeStorage($path);
        Storage::storeAs($destination, $file, $filename);

        return $destination.$filename;
    }

    public function upload_images($request, $file, $path, $item)
    {
        $filename = $file['name'][$item];
        $destination = Storage::makeStorage($path);
        Storage::storeAs($destination, $file, $filename, $item);
        if($filename)
        {
            return $destination.$filename;
        }else{
            return null;
        }
    }


    public function getFileSize($file)
    {
        return  $size = $file['size'];
    }


    public function getOriginalName($file)
    {
        return  $size = $file['name'];
    }

    public function getFileExt($file)
    {
        $data = explode('.', $file['name']);
        return (end($data));
    }

}