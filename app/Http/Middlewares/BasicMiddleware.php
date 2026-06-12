<?php
namespace Bigeweb\App\Http\Middlewares;

use illuminate\Support\Requests\Request;

class BasicMiddleware
{

/**
*
* Handle an incoming request.
* @param Request $request
* @param Callable $next
* @return mixed
*
*/
    public function handle(Request $request, Callable $next)
    {
        return $next($request);
    }
}