<?php
use Bigeweb\Email\Http\Controllers\EmailController;
use illuminate\Support\Routes\Route;

Route::get('configuration/email', [
    EmailController::class, 'index'
])->name('email.index');