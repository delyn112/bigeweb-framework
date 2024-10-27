<?php

namespace Bigeweb\Authentication\Http\Controllers;

use Bigeweb\App\Http\Controllers\Controller;
use Bigeweb\Authentication\Events\ResetPasswordConfirmationEmailEvent;
use Bigeweb\Authentication\Events\ResetPasswordEmailEvent;
use Bigeweb\Authentication\Http\Requests\ChangePasswordRequest;
use Bigeweb\Authentication\Http\Requests\ResetPasswordRequest;
use Bigeweb\Authentication\Repositories\Eloquents\LoginRepository;
use Carbon\Carbon;
use illuminate\Support\Requests\Request;
use illuminate\Support\Requests\Response;
use illuminate\Support\Requests\Validation;
use illuminate\Support\Session;
use illuminate\Support\Str;
use JsonSchema\Validator;

class PasswordController extends Controller
{

    protected LoginRepository $loginRepository;

    public function __construct()
    {
        parent::__construct();
        $this->loginRepository = new LoginRepository();
    }

    public function index()
    {
        return view('auth::reset_password');
    }


    public function create(Request $request)
    {
        $validator = ResetPasswordRequest::rule();
        if($validator)
        {
            return Response::json([
                "status" => 400,
                "errors" => $validator
            ], 400);
        }

        $user = $this->loginRepository->getByEmail($request->input("email"));
        if(!$user)
        {
            return Response::json([
                "status" => "400",
                "message" => "Email does not exist."
            ], 400);
        }else{
            $user =  $this->loginRepository->customUpdate($user->id, [
            "uuid" => Str::string_generator(85),
                "expiry_date" => Carbon::now()->addMinute(15),
            ]);
            $link = route('password-reset-confirmation', ['token' => $user->uuid, 'id' => $user->id, 'username' => $user->username]);
            (new ResetPasswordEmailEvent())->resetNotification($user, $link);
        }

        return Response::json([
            "status" => 200,
            "message" => "Password reset email sent successfully.",
            "redirectURL" => route('forgot-password')
        ]);
    }

    public function edit(Request $request)
    {
        $user = $this->loginRepository->getById($request->input("id"));

        if (!$user || ($user->username != $request->input("username") || $user->uuid != $request->input("token")))
        {
            Session::flash("danger", "Invalid Credential Request!");
            return Response::redirectRoute('forgot-password');
        }else if(strtotime(Carbon::now()) > strtotime($user->expiry_date))
        {
            Session::flash("danger", "Reset password link has expired!");
           return Response::redirectRoute('forgot-password');
        }

        return view("auth::password_change", [
            "user" => $user
        ]);
    }


    public function update(Request $request)
    {
        $validation = ChangePasswordRequest::rules();
        if($validation)
        {
            return Response::json([
                "status" => 400,
                "errors" => $validation
            ], 400);
        }
        $userData = $this->loginRepository->getById($request->input("id"));
        if(!$userData)
        {
            return Response::json([
                "status" => "400",
                "message" => "Invalid credentials.",
                "redirectURL" => route('login')
            ], 400);
        }elseif (VerifyMaskPassword($request->input("password"), $userData->password))
        {
            return Response::json([
                "status" => "400",
                "message" => "Password has been used before."
            ], 400);
        }
        $user = $this->loginRepository->customUpdate($request->input("id"), [
            "uuid" => null,
            "password" => MaskPassword($request->input("password")),
            "expiry_date" => null,
            "remember_me" => null,
        ]);

        (new ResetPasswordConfirmationEmailEvent())->Notification($userData);

        return Response::json([
            "status" => 200,
            "message" => "Password has been changed successfully.",
            "redirectURL" => route('login')
        ], 200);
    }
}