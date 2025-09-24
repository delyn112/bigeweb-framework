<?php

namespace Bigeweb\Authentication\Http\Middlewares;

use Bigeweb\Authentication\Facades\Auth;
use illuminate\Support\Requests\Request;
use illuminate\Support\Requests\Response;

class ResetPasswordMiddleware
{

    public function handle(Request $request, callable $next)
    {
        if(Auth::user() && $request->path() == route('forgot-password'))
        {
            return Response::redirectBack();
        }

        return $next($request);
    }

}