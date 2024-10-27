<?php

namespace Bigeweb\Authentication\Http\Middlewares;

use Bigeweb\Authentication\Facades\Auth;
use illuminate\Support\Requests\Request;
use illuminate\Support\Requests\Response;

class AuthenticateUserMiddleware
{

    public function handle(Request $request, callable $next)
    {
        if(Auth::user() && $request->path() == route('register')
            || Auth::user()  && $request->path() == route('login'))
        {
            return Response::redirectBack();
        }


        if(!Auth::user() && $request->path() !== route('login') && $request->path() !== route('register'))
        {
            return  Response::redirectRoute('login');
        }
        return $next($request);
    }

}