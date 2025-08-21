<?php

namespace Bigeweb\Authentication\Http\Requests;

use illuminate\Support\Requests\Validation;

class CreateUserRequest extends Validation
{

    public static function rules()
    {
        return Validation::attributes([
            "first_name" => ["required"],
            "last_name" => ["required"],
             'username' => ['required', ['unique', 'users:username'], ['min', 'min' => '3'], ['max', 'max' => '15']],
            'email' => ['required',  'email', ['unique', 'users:email']],
            'password' =>  ['required', ['min', 'min' => '8'], ['max', 'max' => '20']],
            'confirm_password' => ['required', ['match', 'match' => 'password']],
        ]);
    }

}