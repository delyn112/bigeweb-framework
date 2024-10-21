<?php

namespace Bigeweb\App\Http\Controllers;

use illuminate\Support\Requests\Request;

class DashboardController extends Controller
{

    /**
     * @return void
     *
     */
    public function index()
    {
        return $this->view('dashboard');
    }

}