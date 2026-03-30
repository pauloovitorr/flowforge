<?php


use App\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;

Route::controller(WorkflowController::class)
    ->middleware('auth')
    ->group(function () {

        Route::get('/workflow', 'index')->name('workflow.index');

        Route::get('/workflow/create', 'create')->name('workflow.create');

        // Route::post('/project', 'store')->name('workflow.store');

        // Route::delete('/workflow/{id}', 'destroy')->name('workflow.destroy');

        // Route::patch('/workflow/{id}', 'update')->name('workflow.update');

    });
