<?php

use Modules\Management\FinanceManagement\Income\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('incomes')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:income-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:income-details|income-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:income-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:income-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:income-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:income-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:income-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:income-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:income-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:income-delete');
    });
});