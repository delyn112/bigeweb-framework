<?php

namespace illuminate\Support\Facades;
use illuminate\Support\Facades\Storage;

class ImageUploadFacade
{
    public static function multipleUpload($request, ?string $requestFileName, ?string $folder)
    {
        $completeFileName = [];
        //loop throught the files
        for($i = 0; $i < count($request->file($requestFileName)['name']); $i++)
        {
            $name = $request->file($requestFileName)["name"][$i];
            $size = $request->file($requestFileName)["size"][$i];
            $type = $request->file($requestFileName)["type"][$i];
            $tmpName = $request->file($requestFileName)["tmp_name"][$i];
            $extension = explode(".", $name);
            if(count($extension) > 0)
            {
                $extension = end($extension);
            }

            //make a new image name for the image
            //$newImageName = uniqid().'_'.time().'.'.$extension;
            $newImageName = md5($name.$size.$type.$extension);
            $completeFileName[] =  Storage::storeAs($tmpName, $folder, $newImageName);
        }

        return $completeFileName;
    }

    public static function singleUpload($request, ?string $requestFileName, ?string $folder)
    {
            $name = $request->file($requestFileName)["name"];
            $size = $request->file($requestFileName)["size"];
            $type = $request->file($requestFileName)["type"];
            $tmpName = $request->file($requestFileName)["tmp_name"];
            $extension = explode(".", $name);
            if(count($extension) > 0)
            {
                $extension = end($extension);
            }

            //make a new image name for the image
             $newImageName = md5($name.$size.$type.$extension);
            $completeFileName =  Storage::storeAs($tmpName, $folder, $newImageName);

        return $completeFileName;
    }

}