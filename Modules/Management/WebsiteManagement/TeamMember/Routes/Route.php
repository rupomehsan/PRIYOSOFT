<?php

use Modules\Management\WebsiteManagement\TeamMember\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('team-members')->middleware('auth:api')->group(function () {
        Route::get('', [Controller::class,'index'])->middleware('permission:team-member-view');
        Route::get('{slug}', [Controller::class,'show'])->middleware('permission:team-member-details|team-member-edit');
        Route::post('store', [Controller::class,'store'])->middleware('permission:team-member-create');
        Route::post('update/{slug}', [Controller::class,'update'])->middleware('permission:team-member-edit');
        Route::post('update-status', [Controller::class,'updateStatus'])->middleware('permission:team-member-edit');
        Route::post('soft-delete', [Controller::class,'softDelete'])->middleware('permission:team-member-delete');
        Route::post('destroy/{slug}', [Controller::class,'destroy'])->middleware('permission:team-member-delete');
        Route::post('restore', [Controller::class,'restore'])->middleware('permission:team-member-delete');
        Route::post('import', [Controller::class,'import'])->middleware('permission:team-member-import');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:team-member-delete');
    });
});