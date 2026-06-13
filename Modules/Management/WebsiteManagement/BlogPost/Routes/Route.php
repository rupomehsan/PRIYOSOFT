<?php

use Modules\Management\WebsiteManagement\BlogPost\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('blog-posts')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:blog-post-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:blog-post-details|blog-post-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:blog-post-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:blog-post-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:blog-post-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:blog-post-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:blog-post-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:blog-post-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:blog-post-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:blog-post-delete');
    });
});