<?php
namespace Bigeweb\Authentication\Http\Controllers;
use Bigeweb\App\Http\Controllers\Controller;
use Bigeweb\Authentication\Events\AuthenticateEvent;
use Bigeweb\Authentication\Events\WelcomeEmailEvent;
use Bigeweb\Authentication\Http\Requests\CreateUserRequest;
use Bigeweb\Authentication\Repositories\Eloquents\RegisterRepository;
use illuminate\Support\Requests\Request;
use illuminate\Support\Requests\Response;

class RegisterController extends Controller
    {

        protected RegisterRepository $registerRepository;
        public function __construct( )
        {
            parent::__construct();
            $this->registerRepository = new RegisterRepository();
        }


        /**
         * Display a listing of the resource (GET /posts).
         */
        public function index()
        {
            return view('auth::register');
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
            //
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