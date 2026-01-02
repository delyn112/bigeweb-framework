<?php

namespace Bigeweb\Authentication\Repositories\Eloquents;

use Bigeweb\Authentication\Enums\RegisterStatusEnum;
use Bigeweb\Authentication\Models\AuthModel;
use Bigeweb\Authentication\Repositories\Interfaces\RegisterRepositoryInterface;
use illuminate\Support\Facades\Config;
use illuminate\Support\Str;

class RegisterRepository implements RegisterRepositoryInterface
{
   protected AuthModel $authModel;

   public function __construct()
   {
       $this->authModel = new AuthModel();
   }


   public function register($request)
   {
      return $this->authModel->save([
          "firstname" => $request->input('first_name'),
          "lastname" => $request->input('last_name'),
          "username" => $request->input('username'),
          "email" => $request->input('email'),
          "password" => MaskPassword($request->input('password')),
           "usertype" => $request->input('usertype'),
           "language" => Config::get('app.locale'),
           "token" => Str::string_generator(60),
          "status" => RegisterStatusEnum::Active->value
       ]);
   }
}