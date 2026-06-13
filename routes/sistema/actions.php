<?php

use App\Http\Controllers\WorkflowActionsController;
use Illuminate\Support\Facades\Route;

Route::controller(WorkflowActionsController::class)
    ->middleware('auth')
    ->group(function () {

         Route::get('/workflow_action', 'index')->name('workflow_action.index');

        Route::get('/workflow_action/create', 'create')->name('workflow_action.create');

        Route::get('/workflow_action/{workflow_action}/edit', 'edit')->name('workflow_action.edit');

        Route::put('/workflow_action/{workflow_action}', 'update')->name('workflow_action.update');

        Route::post('/workflow_action', 'store')->name('workflow_action.store');

        Route::delete('/workflow_action/{workflow_action}', 'destroy')->name('workflow_action.destroy');


    });
