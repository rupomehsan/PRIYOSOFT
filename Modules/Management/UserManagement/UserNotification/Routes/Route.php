<?php

use Modules\Management\UserManagement\UserNotification\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('user-notifications')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:user-notification-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:user-notification-details|user-notification-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:user-notification-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:user-notification-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:user-notification-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:user-notification-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:user-notification-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:user-notification-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:user-notification-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:user-notification-delete');
    });
});