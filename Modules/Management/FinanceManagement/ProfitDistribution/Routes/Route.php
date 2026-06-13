<?php

use Modules\Management\FinanceManagement\ProfitDistribution\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('profit-distributions')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:profit-distribution-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:profit-distribution-details|profit-distribution-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:profit-distribution-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:profit-distribution-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:profit-distribution-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:profit-distribution-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:profit-distribution-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:profit-distribution-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:profit-distribution-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:profit-distribution-delete');
    });
});