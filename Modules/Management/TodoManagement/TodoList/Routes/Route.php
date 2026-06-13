<?php

use Modules\Management\TodoManagement\TodoList\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('todo-lists')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:todo-list-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:todo-list-details|todo-list-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:todo-list-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:todo-list-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:todo-list-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:todo-list-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:todo-list-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:todo-list-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:todo-list-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:todo-list-delete');
    });
});