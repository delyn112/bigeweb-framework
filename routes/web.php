<?php

use Bigeweb\App\Consoles\RunCommands;
use illuminate\Support\Routes\Route;
use Bigeweb\App\Http\Controllers\DashboardController;



Route::get('/', [
    DashboardController::class, 'index'
])->name('home');

Route::get('/hi', function(){
//run the commands
    $cronjobFile = RunCommands::class;
    if(class_exists($cronjobFile))
    {
        $cronjob = new RunCommands();
        return $cronjob->boot();
    }
});
