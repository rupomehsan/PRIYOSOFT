<?php

use Modules\Management\TodoManagement\TodoMilestone\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('todo-milestones')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:todo-milestone-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:todo-milestone-details|todo-milestone-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:todo-milestone-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:todo-milestone-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:todo-milestone-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:todo-milestone-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:todo-milestone-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:todo-milestone-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:todo-milestone-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:todo-milestone-delete');
    });
});