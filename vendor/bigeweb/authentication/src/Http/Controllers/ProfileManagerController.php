<?php

namespace Bigeweb\Authentication\Http\Controllers;


use Bigeweb\App\Http\Controllers\Controller;
use Bigeweb\Authentication\Facades\Auth;
use Bigeweb\Authentication\Http\Requests\ProfileRequest;
use Bigeweb\Authentication\Repositories\Eloquents\ProfileRepository;
use illuminate\Support\Requests\Request;
use illuminate\Support\Requests\Response;

class ProfileManagerController extends Controller
{

protected ProfileRepository $profileRepository;

    public function __construct()
    {
        parent::__construct();
        $this->profileRepository = new ProfileRepository;
    }

    public function index(Request $request)
    {
        $user = $this->profileRepository->getUser($request->input('userid'),
            $request->input('token'));
        return $this->view('auth::profile', ['user' => $user]);
    }

    public function store(Request $request)
    {
       $validation = ProfileRequest::rule();
       if(!$request->input("change-password"))
       {
           unset($validation['password']);
           unset($validation['confirm_password']);
           unset($validation['current_password']);
       }

        if($validation)
       {
           return Response::json([
               "status" => 400,
               "errors" => $validation
           ], 400);
       }

        if($request->input("change-password"))
        {
            if(VerifyMaskPassword($request->input("password"), Auth::user()->password)){
                return Response::json([
                    "status" => "400",
                    "message" => "Password cannot be same with current password."
                ], 400);
            }
        }


           $user = $this->profileRepository->update($request, $request->input('id'));
        return Response::json([
            'status' => 200,
            'message' => "Profile has been updated!.",
            "redirectURL" => route("profile-manager", ['userid' => $user->id, 'token' => $user->token])
        ], 200);

    }
}