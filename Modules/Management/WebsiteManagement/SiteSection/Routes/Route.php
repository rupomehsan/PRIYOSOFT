<?php

use Modules\Management\WebsiteManagement\SiteSection\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('site-sections')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:site-section-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:site-section-details|site-section-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:site-section-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:site-section-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:site-section-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:site-section-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:site-section-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:site-section-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:site-section-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:site-section-delete');
    });
});