<?php

namespace Bigeweb\Authentication\Http\Controllers;

use Bigeweb\App\Http\Controllers\Controller;
use Bigeweb\Authentication\Events\AuthenticateEvent;
use Bigeweb\Authentication\Http\Requests\LoginUserRequest;
use Bigeweb\Authentication\Repositories\Eloquents\LoginRepository;
use illuminate\Support\Cookies;
use illuminate\Support\Requests\Request;
use illuminate\Support\Requests\Response;

class LoginController extends Controller
{
    protected LoginRepository $loginRepository;

    public function __construct()
    {
        parent::__construct();
        $this->loginRepository = new LoginRepository();
    }

    public function index()
    {
        return view('auth::login');
    }

    public function store(Request $request)
    {
        $validation = LoginUserRequest::rule();
        if($validation)
        {
            return Response::json([
                "status" => 400,
                "errors" => $validation
            ], 400);
        }

        $user = $this->loginRepository->process_login($request);
        if(!$user)
        {
            return Response::json([
                'status' => '400',
                'message' => 'This record does not exist in our database!'
            ], 400);
        }elseif(!VerifyMaskPassword($request->input("password"), $user->password))
        {
            return Response::json([
                'status' => '400',
                'message' => 'incorrect password'
            ], 400);
        }else{
            $this->loginRepository->updateLogin($request, $user);
            if($request->input("remember_me") == "Yes")
            {
                Cookies::set('username', $request->input('username'));
                Cookies::set('password', $request->input('password'));
            }else{
                Cookies::destroy('username', '');
                Cookies::destroy('password', '');
            }

            (new AuthenticateEvent())->handle($user->id);

            return Response::json([
                'status' => 200,
                'message' => 'Authentication completed',
                'redirectURL' => route('home')
            ], 200);
        }
    }


    public function destroy(Request $request)
    {
        $this->loginRepository->logout();
        return Response::redirectRoute('home');

    }
}