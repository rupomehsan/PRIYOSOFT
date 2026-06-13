<?php

use Modules\Management\FinanceManagement\Withdrawal\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('withdrawals')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:withdrawal-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:withdrawal-details|withdrawal-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:withdrawal-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:withdrawal-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:withdrawal-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:withdrawal-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:withdrawal-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:withdrawal-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:withdrawal-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:withdrawal-delete');
    });
});