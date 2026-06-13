<?php

use Modules\Management\FinanceManagement\Investment\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('investments')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:investment-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:investment-details|investment-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:investment-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:investment-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:investment-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:investment-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:investment-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:investment-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:investment-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:investment-delete');
    });
});