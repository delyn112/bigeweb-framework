<?php

namespace Bigeweb\App\Http\Controllers;

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