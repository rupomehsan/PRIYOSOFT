<?php

use Modules\Management\FinanceManagement\Investor\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('investors')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:investor-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:investor-details|investor-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:investor-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:investor-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:investor-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:investor-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:investor-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:investor-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:investor-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:investor-delete');
    });
});