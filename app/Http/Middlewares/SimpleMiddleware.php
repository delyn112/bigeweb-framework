<?php

namespace Bigeweb\App\Http\Middlewares;

use illuminate\Support\Requests\Request;

class SimpleMiddleware
{

    public function handle(Request $request, Callable $next)
    {
        return $next($request);
    }
}