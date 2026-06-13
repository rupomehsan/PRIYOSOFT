<?php

use Modules\Management\WebsiteManagement\Subscriber\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('subscribers')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:subscriber-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:subscriber-details|subscriber-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:subscriber-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:subscriber-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:subscriber-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:subscriber-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:subscriber-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:subscriber-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:subscriber-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:subscriber-delete');
    });
});