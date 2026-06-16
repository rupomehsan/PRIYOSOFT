<?php

use Modules\Management\WebsiteManagement\WhoWeAre\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('who-we-ares')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:who-we-are-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:who-we-are-details|who-we-are-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:who-we-are-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:who-we-are-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:who-we-are-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:who-we-are-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:who-we-are-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:who-we-are-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:who-we-are-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:who-we-are-delete');
    });
});