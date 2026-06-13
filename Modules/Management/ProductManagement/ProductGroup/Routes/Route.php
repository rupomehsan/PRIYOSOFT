<?php

use Modules\Management\ProductManagement\ProductGroup\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('product-groups')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:product-group-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:product-group-details|product-group-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:product-group-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:product-group-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:product-group-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:product-group-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:product-group-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:product-group-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:product-group-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:product-group-delete');
    });
});