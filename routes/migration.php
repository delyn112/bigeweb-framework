<?php

use illuminate\Support\Routes\Route;
use illuminate\Support\Requests\Response;
use illuminate\Support\Database\Migration;


Route::get('migration', function () {
 (new Migration())->migrate();
   return Response::redirect('/');
})->name('migration');


//Route::get('migration:rollback', function () {
// (new Migration())->dropdatabase();
//   return Response::redirect('/');
//})->name('migration');
//
