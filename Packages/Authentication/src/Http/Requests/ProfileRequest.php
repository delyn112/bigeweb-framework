<?php

namespace Bigeweb\Authentication\Http\Requests;

use illuminate\Support\Requests\Validation;

class ProfileRequest extends Validation
{

    public static function rule()
    {
        return Validation::attributes([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'password' =>  ['required', ['min', 'min' => '8'], ['max', 'max' => '20']],
            'current_password' =>  ['required', ['min', 'min' => '8'], ['max', 'max' => '20']],
            'confirm_password' => ['required', ['match', 'match' => 'password']],
            'photo' => ['image', ['mimes', 'ext' => 'jpeg,png,jpg'], ['size', 'size' => '2000']]
        ]);
    }


}