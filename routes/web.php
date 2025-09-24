<?php

use illuminate\Support\Routes\Route;
use Bigeweb\App\Http\Controllers\DashboardController;



Route::get('/', [
    DashboardController::class, 'index'
])->name('home');

