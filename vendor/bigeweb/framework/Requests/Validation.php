<?php

namespace illuminate\Support\Requests;

class Validation
{

    public Request  $request;
    protected $error;
    protected ValidationMessages $validationMessages;
    protected Errorbags $errorBag;
    protected ImageValidation $imageValidation;
    protected UniqueValidation $uniqueValidation;

    public function __construct()
    {
        $this->request = new Request();
        $this->error = [];
        $this->validationMessages = new ValidationMessages();
        $this->errorBag = new Errorbags();
        $this->imageValidation = new ImageValidation();
        $this->uniqueValidation = new UniqueValidation();
    }


    public static function attributes(array $parameters = [])
    {
        $validate = new self();
        $validate->Makevalidation($parameters);
        return $validate->getErrorResult();
    }

    public function Makevalidation(array $parameters = [])
    {
       foreach($parameters as $key => $value)
       {
           foreach($value as $rule)
           {
               $ruleName = $rule;
               if(is_array($rule))
               {
                   $rule_key = array_key_first($rule);
                   $ruleName = $rule[$rule_key];
               }

               if($ruleName)
               {
                   //define a constant error message
                  $errorMessage = $this->errorBag->addErrorBag($ruleName, $key);
                   //get the type of input maybe array or string
                   $inputName = $this->getInputName($key);

                   //validate required
                   if($ruleName == 'required' || $ruleName == 'require')
                   {
                       if(!is_array($inputName) && strlen($inputName ?? '') <= 0 && $inputName != '0')
                       {
                           $this->error[$key] = $errorMessage;
                       }elseif(is_array($inputName))
                       {
                           foreach($inputName as $i => $inputValue)
                           {
                               if(strlen($inputValue) <= 0 && $inputValue != '0')
                               {
                                   $this->error[str_replace('.*', '_'.$i+1, $key)] =
                                       str_replace('.*', ' '.$i+1, $errorMessage);
                               }
                           }
                       }
                   }

                   //validate for match mostly for password
                   if($ruleName == "match")
                   {
                        if(!empty($inputName))
                        {
                            if(is_array($inputName))
                            {
                                foreach ($inputName as $i => $inputValue)
                                {
                                   if($this->request->input($rule["match"]) !== $this->request->input(rtrim($key, '.*'))[$i])
                                   {
                                       $errorMsg = str_replace('previous', $rule['match'], $errorMessage);
                                       $this->error[str_replace('.*', '_'.$i+1, $key)] =
                                           str_replace('.*', ' '.$i+1, $errorMsg);
                                   }
                                }
                            }else{
                                if($this->request->input($rule["match"]) !== $this->request->input($key))
                                {
                                    $this->error[$key] = str_replace('previous', $rule['match'], $errorMessage);
                                }
                            }
                        }
                   }

                   //Validate for minimum
                   if($ruleName == 'min')
                   {
                       if(!empty($inputName))
                       {
                           if(is_array($inputName))
                           {
                               foreach ($inputName as $i => $inputValue)
                               {
                                   if(strlen($this->request->input(rtrim($key, '.*'))[$i]) < $rule['min'])
                                   {
                                       $errorMsg = str_replace('{minimum}', $rule['min'], $errorMessage);
                                       $errorMsg = str_replace('The', $key, $errorMsg);
                                       $this->error[str_replace('.*', '_'.$i+1, $key)] =
                                           str_replace('.*', ' '.$i+1, $errorMsg);
                                   }
                               }
                           }else{
                               if(strlen($this->request->input($key)) < $rule['min'])
                               {
                                   $errorMsg = str_replace('{minimum}', $rule['min'], $errorMessage);
                                   $errorMsg = str_replace('The', $key, $errorMsg);
                                   $this->error[$key] = $errorMsg;
                               }
                           }
                       }
                   }

                   //Validate for max
                   if($ruleName == 'max')
                   {
                       if(!empty($inputName))
                       {
                           if(is_array($inputName))
                           {
                               foreach ($inputName as $i => $inputValue)
                               {
                                   if(strlen($this->request->input(rtrim($key, '.*'))[$i]) > $rule['max'])
                                   {

                                       $errorMsg = str_replace('{maximum}', $rule['max'], $errorMessage);
                                       $errorMsg = str_replace('The', $key, $errorMsg);
                                       $this->error[str_replace('.*', '_'.$i+1, $key)] =
                                          str_replace('.*', ' '.$i+1, $errorMsg);
                                   }
                               }
                           }else{
                               if(strlen($this->request->input($key)) > $rule['max'])
                               {
                                   $errorMsg = str_replace('{maximum}', $rule['max'], $errorMessage);
                                   $errorMsg = str_replace('The', $key, $errorMsg);
                                   $this->error[$key] = $errorMsg;
                               }
                           }
                       }
                   }


                   //validate email
                   if($ruleName == 'email')
                   {
                       if(!empty($inputName))
                       {
                           if(is_array($inputName)){
                               foreach ($inputName as $i => $inputValue)
                               {
                                   if(!filter_var($this->request->input(rtrim($key, '.*'))[$i],
                                       FILTER_VALIDATE_EMAIL))
                                   {
                                       $this->error[str_replace('.*', '_'.$i+1, $key)] =
                                           str_replace('.*', ' '.$i+1, $errorMessage);
                                   }
                               }
                           }else{
                               if(!filter_var($this->request->input($key), FILTER_VALIDATE_EMAIL))
                               {
                                   $this->error[$key] = $errorMessage;
                               }
                           }
                       }
                   }
               }
           }
       }
       //process for images and more
        $this->error = array_merge($this->error,
            $this->imageValidation->validateImage($parameters),
        $this->uniqueValidation->validateUnique($parameters));
    }


    public function getInputName($attribute_param)
    {
        $inputName = $this->request->input($attribute_param);
            if(strpos($attribute_param, '.*') !== false)
            {
                //means it is an array input
                //return the names in array_format
                $input_name = rtrim($attribute_param, '.*');
                $inputName = $this->request->input($input_name, []);
            }
            return $inputName;
    }


    public function getErrorResult()
    {
        return $this->error;
    }

}