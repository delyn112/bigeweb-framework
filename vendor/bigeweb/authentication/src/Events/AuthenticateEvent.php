<?php

namespace Bigeweb\Authentication\Events;

use Bigeweb\Authentication\Repositories\Eloquents\LoginRepository;
use illuminate\Support\Session;

class AuthenticateEvent
{

    public function handle(?int $id)
    {
       $user =  (new LoginRepository())->getById($id);
        Session::session_set($user->usertype, $user);
    }
}