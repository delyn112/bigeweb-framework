<?php

namespace Bigeweb\Authentication\Repositories\Eloquents;

use Bigeweb\Authentication\Models\AuthModel;
use Bigeweb\Authentication\Repositories\Interfaces\ProfileRepositoryInterface;
use illuminate\Support\Facades\ImageUploadFacade;

class ProfileRepository implements ProfileRepositoryInterface
{
    protected AuthModel $authModel;


    public function __construct()
    {
       $this->authModel = new AuthModel();
    }



    public function getUser(int $id = null, string $token = null)
    {
        $user = $this->authModel->query("SELECT * FROM users
         WHERE id='$id' AND token='$token'")
            ->first();

        return ($user) ;
    }

    public function update($request, $id)
    {
        $image = $request->input("old_photo");
        if($request->file("photo"))
        {
            $image = ImageUploadFacade::singleUpload($request, "photo", 'profile_pictures');
        }
        //check if user record exists
      return $this->authModel->updateOrcreate($id, [
          "firstname" => $request->input('first_name'),
          "lastname" => $request->input('last_name'),
          "password" => MaskPassword($request->input('password')),
          "avatar" => $image,
      ]);
    }


    public function updateVerifyEmail(?int $id,?array $data)
    {
        return $this->authModel->update($id, $data);
    }
}