<?php

namespace Bigeweb\Authentication\Models;

use illuminate\Support\Models\Model;

class AuthModel extends Model
{

    protected $table = "users";
    protected $filable = [
        "first_name",
        "last_name",
        "username",
        "email",
        "password",
        "token",
        "usertype",
        "status"
    ];
}