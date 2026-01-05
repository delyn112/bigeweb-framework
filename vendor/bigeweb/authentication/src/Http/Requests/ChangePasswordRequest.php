<?php

namespace Bigeweb\Authentication\Http\Requests;

use illuminate\Support\Requests\Validation;

class ChangePasswordRequest extends Validation
{

    public static function rules()
    {
        return Validation::attributes([
            'password' =>  ['required', ['min', 'min' => '8'], ['max', 'max' => '20']],
            'confirm_password' => ['required', ['match', 'match' => 'password']],
        ]);
    }

}