<?php
use illuminate\Support\Routes\Route;


Route::get('make:migration/?user', function () {
    return (new \illuminate\Support\Database\MakeMigration())
        ->make();
});


Route::get('make:model/?user', function () {
    return (new \illuminate\Support\Models\GenerateModel())
        ->make();
});

Route::get('make:controller/?user', function () {
    return (new \illuminate\Support\Http\Controllers\GenerateController())
        ->make();
});
