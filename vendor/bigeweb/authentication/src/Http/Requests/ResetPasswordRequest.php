<?php

namespace Bigeweb\Authentication\Http\Requests;

use illuminate\Support\Requests\Validation;

class ResetPasswordRequest extends Validation
{
    public static function rule()
    {
        return  Validation::attributes([
            'email' => ['required', 'email'],
        ]);
    }
}