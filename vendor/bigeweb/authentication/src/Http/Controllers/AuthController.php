<?php

namespace Bigeweb\Authentication\Http\Controllers;

use Bigeweb\App\Http\Controllers\Controller;
use Bigeweb\Authentication\Events\AuthenticateEvent;
use Bigeweb\Authentication\Events\WelcomeEmailEvent;
use Bigeweb\Authentication\Http\Requests\CreateUserRequest;
use Bigeweb\Authentication\Repositories\Eloquents\RegisterRepository;
use illuminate\Support\Requests\Request;
use illuminate\Support\Requests\Response;

class AuthController extends Controller
{

    protected RegisterRepository $registerRepository;
    public function __construct( )
    {
        parent::__construct();
        $this->registerRepository = new RegisterRepository();
    }



    public function index()
    {
        return view('auth::register');
    }

    public function store(Request $request)
    {

        $validation = CreateUserRequest::rules();
        if($validation)
        {
            return Response::json([
                "status" => 400,
                "errors" => $validation
            ], 400);
        }
        $user = $this->registerRepository->register($request);
        (new WelcomeEmailEvent())->welcome($user);
        (new AuthenticateEvent())->handle($user->id);
        return Response::json([
            "status" => 200,
            "data" => $user,
            "message" => "User created successfully",
            "redirectURL" => route('home')
        ], 200);
    }
}