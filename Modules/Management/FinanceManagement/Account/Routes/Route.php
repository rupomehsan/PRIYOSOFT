<?php

use Modules\Management\FinanceManagement\Account\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('accounts')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:account-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:account-details|account-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:account-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:account-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:account-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:account-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:account-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:account-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:account-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:account-delete');
    });
});