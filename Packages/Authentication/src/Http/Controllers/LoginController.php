<?php
namespace Bigeweb\Authentication\Http\Controllers;
use Bigeweb\App\Http\Controllers\Controller;
use Bigeweb\Authentication\Events\AuthenticateEvent;
use Bigeweb\Authentication\Http\Requests\LoginUserRequest;
use Bigeweb\Authentication\Repositories\Eloquents\LoginRepository;
use illuminate\Support\Cookies;
use illuminate\Support\Requests\Response;
use illuminate\Support\Requests\Request;
use illuminate\Support\Session;

class LoginController extends Controller
    {
    protected LoginRepository $loginRepository;
         public function __construct()
        {
            parent::__construct();
            $this->loginRepository = new LoginRepository();
        }
    
        /**
         * Display a listing of the resource (GET /posts).
         */
        public function index()
        {
            Session::session_set("user_previous_url", $_SERVER["HTTP_REFERER"] ?? '');
            return view('auth::login');
        }
    
        /**
         * Show the form for creating a new resource (GET /posts/create).
         */
        public function create()
        {
            //
        }
    
        /**
         * Store a newly created resource in storage (POST /posts).
         */
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

                $url = Session::session_get("user_previous_url") ?? route('home');
                return Response::json([
                    'status' => 200,
                    'message' => 'Authentication completed',
                    'redirectURL' => $url
                ], 200);
            }
        }
    
        /**
         * Display the specified resource (GET /posts/{id}).
         */
        public function show(Request $request)
        {
            //
        }
    
        /**
         * Show the form for editing the specified resource (GET /posts/{id}/edit).
         */
        public function edit(Request $request)
        {
            //
        }
    
        /**
         * Update the specified resource in storage (PUT/PATCH /posts/{id}).
         */
        public function update(Request $request)
        {
           //
        }
    
        /**
         * Remove the specified resource from storage (DELETE /posts/{id}).
         */
        public function destroy(Request $request)
        {
            $this->loginRepository->logout();
            return Response::redirectRoute('home');
        }
    
        /**
         * Search posts by title or body (GET /posts/search?query=...).
         */
        public function search(Request $request)
        {
            //
        }
    
        /**
         * Restore a soft-deleted post (POST /posts/{id}/restore).
         */
        public function restore(Request $request)
        {
           //
        }
    
        /**
         * Permanently delete a soft-deleted post (DELETE /posts/{id}/force).
         */
        public function forceDelete(Request $request)
        {
           //
        }
    
    }