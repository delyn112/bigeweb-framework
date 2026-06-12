<?php

namespace illuminate\Support\Requests;


class ImageValidation
{
    public Request $request;
    public Errorbags $errorBag;


    protected $systemMemory = 0;

    public function __construct()
    {
        $uploadlimit = ini_get('upload_max_filesize');
        if ($uploadlimit !== null) {
            $unit = strtoupper(substr($uploadlimit, -1));
            $value = (int)$uploadlimit;

            switch ($unit) {
                case 'G':
                    $sizeValue =  $value * 1024 * 1024;
                    break;
                case 'M':
                    $sizeValue =  $value;
                    break;
                case 'K':
                    $sizeValue =  $value / 1024;
                    break;
                default:
                    $sizeValue = $value  / (1024 * 1024);
                    break;
            }

            //size value in mb
            $sizeValue = ceil($sizeValue);
            $sizeValue = $sizeValue > 0 ? $sizeValue :  1;

            $this->systemMemory = $sizeValue;
            $this->request = new Request();
            $this->errorBag = new Errorbags();
        }
    }


    public function validateImage(array $parameters = [])
    {
        $error = [];
        foreach ($parameters as $key => $value)
        {
            $requestName = str_replace('.*', '', $key);
            foreach($value as $rule) {
                $ruleName = $rule;
                if (is_array($rule)) {
                    $rule_key = array_key_first($rule);
                    $ruleName = $rule[$rule_key];
                }

                if ($ruleName) {
                    //define a constant error message
                    $errorMessage = $this->errorBag->addErrorBag($ruleName, $key);
                    //get the type of input maybe array or string
                    $inputName = $this->getInputFile($key);

                    //general validation for size not greater than system requirement
                    if(!empty($inputName))
                    {
                        if(is_array($inputName))
                        {
                            foreach ($inputName as $i => $inputValue)
                            {
                                $convertsionTomb = ($this->request->file(rtrim($key, '.*'))["size"][0]  / (1024 * 1024));
                                 if( round($convertsionTomb, 2) > $this->systemMemory)
                                {
                                    $upload_max = $this->systemMemory;
                                    $error[str_replace('.*', '_'.$i+1, $key)] =
                                        str_replace('.*', ' '.$i+1, $key)." is too large for server to process. Maximum allowed upload size is $upload_max mb";
                                }
                            }
                        }else{
                            $convertsionTomb = $this->request->file(rtrim($key))["size"]  / (1024 * 1024);
                            if(round($convertsionTomb) > $this->systemMemory)
                            {
                                $upload_max = $this->systemMemory;
                                $error[$key] = "$key is too large for server to process. Maximum allowed upload size is $upload_max mb";
                            }
                        }

                        if(!empty($this->request->file($requestName)["name"][0]))
                        {
                            //validate its extension
                            if($ruleName == 'mimes')
                            {
                                if(is_array($inputName))
                                {
                                    foreach($inputName as $i => $inputValue)
                                    {
                                        $image = $this->request->file(rtrim($key, '.*'));
                                        $image = explode('.', $image['name'][$i]);
                                        $filetype = end($image);

                                        $extension = str_replace(' ', '', $rule['ext']);
                                        $extension = explode(',',  $extension);

                                        if(!in_array(strtolower($filetype), $extension))
                                        {
                                            $error_name = str_replace('.*', ' '.$i+1, $key);
                                            $error[str_replace('.*', '_'.$i+1, $key)] = $error_name.' '.str_replace('{extension}', $rule['ext'], $errorMessage);
                                        }
                                    }
                                }else{
                                    $image = $this->request->file($key);
                                    $image = explode('.', $image['name']);
                                    $filetype = end($image);

                                    $extension = str_replace(' ', '', $rule['ext']);
                                    $extension = explode(',',  $extension);

                                    if(!in_array(strtolower($filetype), $extension))
                                    {
                                        $error[$key] = str_replace('{extension}', $rule['ext'], $errorMessage);
                                    }
                                }
                            }

                            //validate its size
                            if($ruleName == 'size')
                            {
                                if(is_array($inputName))
                                {
                                    foreach($inputName as $i => $inputValue)
                                    {
                                        $size = $this->request->file(rtrim($key, '.*'))['size'][$i];
                                        $sizeMb = $size / (1024 * 1024);
                                        if($sizeMb > $rule['size'])
                                        {
                                            $error_name = str_replace('.*', ' '.$i+1, $key);
                                            $error[str_replace('.*', '_'.$i+1, $key)] = $error_name.' '.str_replace('{size}', ($rule['size']), $errorMessage);
                                        }
                                    }
                                }else{
                                    $sizeMb = $this->request->file($key)['size']  / (1024 * 1024);
                                    if($sizeMb > $rule['size'])
                                    {
                                        $error[$key] = str_replace('{size}', ($rule['size']), $errorMessage);
                                    }
                                }
                            }

                            //validate its type
                            if($ruleName == 'video' || $ruleName == 'audio' || $ruleName == 'image')
                            {
                                if(is_array($inputName))
                                {
                                    foreach($inputName as $i => $inputValue)
                                    {
                                        if(isset($this->request->file($key)['type'][$i]))
                                        {
                                            $type = $this->request->file($key)['type'][$i];
                                            $type = array_reverse(explode('/' , $type));
                                            $type = end($type);
                                            if($type !== $ruleName)
                                            {
                                                $error_name = str_replace('.*', ' '.$i+1, $key);
                                                $error[str_replace('.*', '_'.$i+1, $key)] = $error_name.' '.$errorMessage;
                                            }
                                        }
                                    }
                                }else{
                                    $type = $this->request->file($key)['type'];
                                    $type = array_reverse(explode('/' , $type));
                                    $type = end($type);
                                    if($type !== $ruleName)
                                    {
                                        $error[$key] = $errorMessage;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $error;
    }

    public function getInputFile($attribute_param)
    {
        if (strpos($attribute_param, '.*') !== false)
        {
            $attribute_param = rtrim($attribute_param, '.*');
        }

        $inputName = null;
        if($this->request->file($attribute_param))
        {
            if(is_string($this->request->file($attribute_param)['name']))
            {
                $inputName = $this->request->file($attribute_param)['name'];
            }elseif(is_array($this->request->file($attribute_param)['name']))
            {
                //means it is an array input
                //return the names in array_format
                $input_name = rtrim($attribute_param, '.*');
                $inputName = $this->request->file($input_name)['name'];
            }
        }


        return $inputName;
    }
}