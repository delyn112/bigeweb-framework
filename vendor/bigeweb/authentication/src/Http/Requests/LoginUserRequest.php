<?php

namespace Bigeweb\Authentication\Http\Requests;

use illuminate\Support\Requests\Validation;

class LoginUserRequest extends Validation
{
    public static function rule()
    {
       return  Validation::attributes([
            'username' => ['required'],
            'password' =>  ['required'],
        ]);
    }
}