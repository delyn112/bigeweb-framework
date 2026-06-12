<?php

namespace Bigeweb\Authentication\Facades;



use Bigeweb\Authentication\Repositories\Eloquents\LoginRepository;
use illuminate\Support\Session;

class Auth
{

    protected LoginRepository $loginRepository;

    public function __construct()
    {
        $this->loginRepository = new LoginRepository();
    }

    public static function user()
    {
        $user = Session::session_get('user');
        if($user)
        {
            $self = new self();
            $user = $self->loginRepository->getById($user->id);
            return $user;
        }
        return null;
    }
}