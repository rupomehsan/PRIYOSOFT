<?php

use Modules\Management\FinanceManagement\ExpenseCategory\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('expense-categories')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:expense-category-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:expense-category-details|expense-category-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:expense-category-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:expense-category-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:expense-category-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:expense-category-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:expense-category-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:expense-category-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:expense-category-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:expense-category-delete');
    });
});