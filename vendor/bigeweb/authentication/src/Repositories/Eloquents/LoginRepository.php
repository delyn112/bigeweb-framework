<?php

namespace Bigeweb\Authentication\Repositories\Eloquents;


use Bigeweb\Authentication\Models\AuthModel;
use Bigeweb\Authentication\Repositories\Interfaces\LoginRepositoryInterface;
use illuminate\Support\Session;
use illuminate\Support\Str;

class LoginRepository implements LoginRepositoryInterface
{

    protected AuthModel $authModel;


    public function __construct()
    {
       $this->authModel = new AuthModel();
    }


    public function getById(int $id)
    {
        $user = $this->authModel->find("id", $id);
        return $user;
    }

    public function getByEmail(?string $email)
    {
        $user = $this->authModel->find("email", $email);
        return $user;
    }


    public function process_login($request)
    {
        if(filter_var($request->input("username"), FILTER_VALIDATE_EMAIL))
        {
            $user = $this->authModel->find('email', $request->input("username"));
        }else{
            $user = $this->authModel->find('username', $request->input("username"));
        }

        return ($user);
    }


    public function updateLogin($request, mixed $user)
    {
            $this->authModel->update($user->id, [
            "remember_me" => $request->input("remember_me") == "Yes" ?
                Str::string_generator(67) : null,
            ]);
    }


    public function customUpdate(int $id, array $data)
    {
           return $this->authModel->update($id, $data);
    }

    public function logout()
    {
        Session::session_delete('admin');
        Session::session_delete('user');
    }
}