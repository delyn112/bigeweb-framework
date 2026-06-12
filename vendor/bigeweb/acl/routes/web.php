<?php

use illuminate\Support\Routes\Route;
use Bigeweb\Acl\Http\Controllers\RegionalJsonController;

Route::post('country/json/get-regional-zones',
    [
        RegionalJsonController::class, 'getStates'
    ])
    ->name('fetch-region');