<?php
namespace Bigeweb\App\Http\Requests;
use illuminate\Support\Requests\Validation;

class BasicRequest extends Validation
{

        /**
        *
        *
        *important validation keys
        * @return array
        *['required']
        *['unique', 'unique:users']
        *['email']
        *['min', 'min' => '8']
        *['max', 'max' => '20']
        *['match', 'match' => 'password']
        *['mimes', 'ext' =>'jpeg, png, jpg']
        *['image']
        *['size', 'size' => '2000']
        *
        *
        */


    public static function validate()
    {
        return Validation::attributes([
            'name' => ['required'],
            'email' => ['required', ['unique', 'unique:users'], 'email'],
            'username' => ['required', ['unique', 'admins:username']],
            'password' =>  ['required', ['min', 'min' => '8'], ['max', 'max' => '20']],
            'confirm_password' => ['required', ['match', 'match' => 'password']],
            'terms' => ['required'],
            'photo' => [['mimes', 'ext' =>'jpeg, png, jpg'], 'image', ['size', 'size' => '2000']]
        ]);
    }
}