<?php
namespace Bigeweb\App\Http\Request;
use illuminate\Support\Requests\Validation;

class BasicRequest extends Validation
{

    public function rules()
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