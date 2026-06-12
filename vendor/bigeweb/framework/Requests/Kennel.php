<?php

namespace illuminate\Support\Requests;

use illuminate\Support\Requests\Response;

class Kennel
{
    public function handle($request, int $code = 200) : Response
    {
        return new Response($request, $code);
    }
}