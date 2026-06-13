<?php

use Modules\Management\TodoManagement\TodoGroup\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('todo-groups')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:todo-group-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:todo-group-details|todo-group-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:todo-group-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:todo-group-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:todo-group-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:todo-group-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:todo-group-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:todo-group-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:todo-group-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:todo-group-delete');
    });
});