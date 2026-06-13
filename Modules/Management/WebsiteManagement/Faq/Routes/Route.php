<?php

use Modules\Management\WebsiteManagement\Faq\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('faqs')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:faq-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:faq-details|faq-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:faq-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:faq-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:faq-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:faq-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:faq-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:faq-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:faq-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:faq-delete');
    });
});