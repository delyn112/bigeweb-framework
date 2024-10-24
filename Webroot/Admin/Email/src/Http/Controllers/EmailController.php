<?php

namespace Bigeweb\Email\Http\Controllers;

use Bigeweb\App\Http\Controllers\Controller;

class EmailController extends Controller
{

    public function index()
    {
        return $this->view('email::email');
    }
}