<?php

namespace Bigeweb\Authentication\Facades;

class Authcheck
{

    public static function user()
    {
        // Return the authenticated user or null
        return Auth::user() ?: null;
    }
}