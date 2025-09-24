<?php

namespace illuminate\Support\Requests;

class ValidationMessages
{

    public function errorMessages()
    {
        return [
            'required' => 'This field is required!',
            'match' => 'This field must match with previous field!',
            'min' => 'The value must be greater than {minimum} characters.',
            'max' => 'The value must be less than {maximum} characters.',
            'email' => 'This is not a valid email address!',
            'unique' => 'This {key} has been taken',
            'image' => 'This field is required and must be an image.',
            'video' => 'This field is required and must be a video.',
            'audio' => 'This field is required and must be an audio.',
            'file' => 'Upload the requested file to continue.',
            'mimes' => 'Allowed file type are {extension}.',
            'size' => 'File is too large. Allowed maximum size is {size}mb.'
        ];
    }
}