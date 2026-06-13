<?php

use Modules\Management\FinanceManagement\Expense\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('expenses')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:expense-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:expense-details|expense-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:expense-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:expense-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:expense-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:expense-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:expense-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:expense-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:expense-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:expense-delete');
    });
});