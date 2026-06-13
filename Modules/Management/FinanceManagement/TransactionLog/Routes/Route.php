<?php

use Modules\Management\FinanceManagement\TransactionLog\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('transaction-logs')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:transaction-log-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:transaction-log-details|transaction-log-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:transaction-log-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:transaction-log-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:transaction-log-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:transaction-log-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:transaction-log-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:transaction-log-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:transaction-log-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:transaction-log-delete');
    });
});