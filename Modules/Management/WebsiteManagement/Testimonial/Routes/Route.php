<?php

use Modules\Management\WebsiteManagement\Testimonial\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('testimonials')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:testimonial-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:testimonial-details|testimonial-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:testimonial-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:testimonial-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:testimonial-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:testimonial-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:testimonial-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:testimonial-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:testimonial-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:testimonial-delete');
    });
});