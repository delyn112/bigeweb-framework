<?php

namespace illuminate\Support\Requests;

use Illuminate\Support\Facades\View;
use illuminate\Support\Models\model;

class UniqueValidation
{

    public Errorbags $errorBag;
    public Request $request;



    public function __construct()
    {
        $this->request = new Request();
        $this->errorBag = new Errorbags();
    }

    public function validateUnique(array $parameters = [])
    {
        $error = [];
        foreach ($parameters as $key => $value) {
            foreach ($value as $rule) {
                $ruleName = $rule;
                if (is_array($rule)) {
                    $rule_key = array_key_first($rule);
                    $ruleName = $rule[$rule_key];
                }

                if ($ruleName) {
                    //define a constant error message
                    $errorMessage = $this->errorBag->addErrorBag($ruleName, $key);
                    //get the type of input maybe array or string
                    $inputName = (new Validation())->getInputName($key);

                    if($ruleName == 'unique')
                    {
                        if(is_array($inputName))
                        {
                            foreach ($inputName as $inputKey => $inputValue) {
                                $getTableName = explode(':', end($rule));
                                $table = array_reverse($getTableName);
                                $table = array_pop($table);

                                $table_column = end($getTableName);
                                $modelData = (new model())
                                    ->query("select * from $table where $table_column = '$inputValues'")
                                    ->get();
                                if(count($modelData) > 0)
                                {
                                    $error[$key] =  str_replace('{key}', $inputName, $errorMessage );
                                }
                            }

                        }else{
                            $getTableName = explode(':', end($rule));
                            $table = array_reverse($getTableName);
                            $table = array_pop($table);

                            $table_column = end($getTableName);
                            $modelData = (new model())
                                ->query("select * from $table where $table_column = '$inputName'")
                                ->get();

                            if(count($modelData) > 0)
                            {
                                $error[$key] =  str_replace('{key}', $inputName, $errorMessage );
                            }
                        }
                    }
                }
            }
        }

        return $error;
    }


}