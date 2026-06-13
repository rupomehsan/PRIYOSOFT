<?php

use Modules\Management\FinanceManagement\AccountTransfer\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('account-transfers')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:account-transfer-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:account-transfer-details|account-transfer-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:account-transfer-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:account-transfer-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:account-transfer-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:account-transfer-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:account-transfer-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:account-transfer-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:account-transfer-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:account-transfer-delete');
    });
});