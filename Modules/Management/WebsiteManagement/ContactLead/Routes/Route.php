<?php

use Modules\Management\WebsiteManagement\ContactLead\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('contact-leads')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:contact-lead-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:contact-lead-details|contact-lead-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:contact-lead-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:contact-lead-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:contact-lead-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:contact-lead-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:contact-lead-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:contact-lead-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:contact-lead-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:contact-lead-delete');
    });
});