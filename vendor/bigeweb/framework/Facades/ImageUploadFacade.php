<?php

namespace illuminate\Support\Facades;

use illuminate\Support\Exceptions\FileUploadException;
use illuminate\Support\Facades\Storage;
use Throwable;

class ImageUploadFacade extends FileUploadException
{
    /**
     * @param $request
     * @param string|null $requestFileName
     * @param string|null $folder
     * @return array
     * @throws FileUploadException
     * @throws \Safe\Exceptions\HashException
     *
     */
    public static function multipleUpload($request, ?string $requestFileName, ?string $folder)
    {
        if (!$request || !$requestFileName || !$folder) {
            throw self::missingParameters();
        }


        $requestFiles = (object)$request->file($requestFileName);
        //normalize the files
        $files = (new self())->normalizeFile($requestFiles);
        $completeFileName = [];
        foreach($files as $file)
        {
            $objectData = (object)$file;
            $completeFileName[] = (new self())->fileUpload($objectData, $folder);
        }
        return ($completeFileName);
    }


    /**
     * @param object $files
     * @return array|null
     *
     */
    private function normalizeFile(object $files) : ?array
    {
        $fileArray = [];
        $uploadedFiles = $files;
        if(!is_array($uploadedFiles->name))
        {
            throw FileUploadException::arrayFileExpected();
        }
        for ($i = 0; $i < count($uploadedFiles->name); $i++) {
            $fileArray[] = [
                "name" => $uploadedFiles->name[$i],
                "full_path" => $uploadedFiles->full_path[$i],
                "type" => $uploadedFiles->type[$i],
                "tmp_name" => $uploadedFiles->tmp_name[$i],
                "error" => $uploadedFiles->error[$i],
                "size" => $uploadedFiles->size[$i],
            ];
        }
        return $fileArray;
    }


    /**
     * @param object $objectData
     * @return string
     * @throws FileUploadException
     * @throws \Safe\Exceptions\HashException
     *
     */
    private function fileUpload(object $objectData, string $folder) : string
    {
        $name = $objectData->name;
        $size = $objectData->size;
        $type = $objectData->type;
        $tmpName = $objectData->tmp_name;
        $extension = pathinfo($name, PATHINFO_EXTENSION);

        if (!$tmpName || !file_exists($tmpName)) {
            throw self::fromUploadError(UPLOAD_ERR_NO_TMP_DIR);
        }

        $newImageName = \Safe\hash_file('sha256', $tmpName) . "." . $extension;
        $completeFileName = Storage::storeAs($tmpName, $folder, $newImageName);

        return $completeFileName;
    }

    /**
     * @param $request
     * @param string|null $requestFileName
     * @param string|null $folder
     * @return string
     * @throws FileUploadException
     * @throws \Safe\Exceptions\HashException
     */
    public static function singleUpload($request, ?string $requestFileName, ?string $folder) : string
    {
        if (!$request || !$requestFileName || !$folder) {
            throw self::missingParameters();
        }

        $objectData = (object)$request->file($requestFileName);
       $uploaded = (new self())->fileUpload($objectData, $folder);
       return $uploaded;
    }

}