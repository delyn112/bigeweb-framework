<?php

use Bigeweb\Authentication\Http\Controllers\ProfileManagerController;
use illuminate\Support\Routes\Route;

Route::get('profile/?userid=:userid&token=:token', [
    ProfileManagerController::class, 'index'
])->middleware(['web', 'Auth', 'isEmailVerified'])
    ->name('profile-manager');

Route::post('profile/save', [
    ProfileManagerController::class, 'store'
])->middleware(['web','Auth', 'isEmailVerified'])
    ->name('store-profile');
