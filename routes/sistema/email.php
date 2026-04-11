<?php

use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;

Route::controller(EmailController::class)
    ->middleware('auth')
    ->group(function () {

         Route::get('/email', 'index')->name('email.index');

        Route::get('/email/create', 'create')->name('email.create');

        Route::get('/email/{email}/edit', 'edit')->name('email.edit');

        Route::put('/email/{email}', 'update')->name('email.update');

        Route::post('/email', 'store')->name('email.store');

        Route::delete('/email/{email}', 'destroy')->name('email.destroy');

        

    });
