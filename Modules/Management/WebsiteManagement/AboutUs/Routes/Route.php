<?php

use Modules\Management\WebsiteManagement\AboutUs\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('about-uses')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:about-us-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:about-us-details|about-us-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:about-us-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:about-us-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:about-us-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:about-us-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:about-us-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:about-us-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:about-us-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:about-us-delete');
    });
});