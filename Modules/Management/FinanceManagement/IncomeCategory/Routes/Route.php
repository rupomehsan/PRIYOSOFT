<?php

use Modules\Management\FinanceManagement\IncomeCategory\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('income-categories')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:income-category-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:income-category-details|income-category-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:income-category-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:income-category-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:income-category-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:income-category-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:income-category-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:income-category-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:income-category-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:income-category-delete');
    });
});