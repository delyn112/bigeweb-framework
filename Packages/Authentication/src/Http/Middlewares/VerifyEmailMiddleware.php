<?php

namespace Bigeweb\Authentication\Http\Middlewares;

use Bigeweb\Authentication\Facades\Auth;
use Bigeweb\Authentication\Facades\Authcheck;
use illuminate\Support\Requests\Request;
use illuminate\Support\Requests\Response;

class VerifyEmailMiddleware
{

    public function handle(Request $request, callable $next)
    {
        if(Authcheck::user() && !Auth::user()->email_verified_at)
        {
            return Response::redirectRoute('verify-email');
        }

        return $next($request);
    }

}