<?php 

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::controller(ProjectController::class)
    ->group(function(){

        Route::get('/project', 'index')->name('project.index');

        Route::post('/project', 'store')->name('project.store');

        Route::delete('/project/{id}', 'destroy')->name('project.destroy');

    });