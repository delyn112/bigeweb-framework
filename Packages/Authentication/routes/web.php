<?php


use Bigeweb\Authentication\Http\Controllers\LoginController;
use Bigeweb\Authentication\Http\Controllers\PasswordController;
use Bigeweb\Authentication\Http\Controllers\RegisterController;
use Bigeweb\Authentication\Http\Controllers\VerifyEmailController;
use illuminate\Support\Routes\Route;

Route::get('/register', [
    RegisterController::class, 'index'
])->name('register')
    ->middleware(['Auth']);


Route::post('/register/store', [
    RegisterController::class, 'store'
])->name('register.store');



Route::get('/login', [
    LoginController::class, 'index'
])->name('login')
    ->middleware(['Auth']);



Route::post( '/login/authenticate', [
    LoginController::class, 'store'
])->name('login.store');



Route::get('/logout', [
    LoginController::class, 'destroy'
])->name('logout');


Route::get('/password/forgot', [
   PasswordController::class, 'index'
])->name('forgot-password')->middleware(['web']);

Route::post('/password/forgot/reset', [
   PasswordController::class, 'create'
])->name('reset-password')->middleware(['web']);

Route::get('/password/forgot/reset/?token=:token&id=:id&username=:username', [
   PasswordController::class, 'edit'
])->name('password-reset-confirmation')->middleware(['web']);


Route::post('/password/forgot/reset/change', [
    PasswordController::class, 'update'
])->name('change-password-confirmation')->middleware(['web']);


Route::get('/verify-email', [
    VerifyEmailController::class, 'index'
])->name('verify-email')->middleware(['web', 'Auth']);


Route::get('/verify-email/confirmation/?token=:token&id=:id&username=:username', [
    VerifyEmailController::class, 'store'
])->name('confirm-verify-email')->middleware(['web', 'Auth']);

Route::get('/verify-email/resend', [
    VerifyEmailController::class, 'create'
])->name('resend-verification-link')->middleware(['web', 'Auth']);

?>