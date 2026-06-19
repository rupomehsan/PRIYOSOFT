<?php

use Modules\Management\OrderManagement\Order\Controller\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes — no auth required (frontend Payment.vue form submission)
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::prefix('orders')->group(function () {
        Route::post('submit', [Controller::class, 'publicStore']);
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes — require auth:api + permissions
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::prefix('orders')->middleware('auth:api')->group(function () {

        // List & detail
        Route::get('', [Controller::class, 'index'])->middleware('permission:order-view');
        Route::get('{slug}', [Controller::class, 'show'])->middleware('permission:order-details|order-edit');

        // Create & edit (admin-side)
        Route::post('store', [Controller::class, 'store'])->middleware('permission:order-create');
        Route::post('update/{slug}', [Controller::class, 'update'])->middleware('permission:order-edit');

        // Order lifecycle status (pending_payment → payment_verified → in_progress → completed …)
        Route::post('{slug}/update-order-status', [Controller::class, 'updateOrderStatus'])->middleware('permission:order-edit');

        // Payment management
        Route::get('{slug}/payments', [Controller::class, 'getPayments'])->middleware('permission:order-details|order-edit');
        Route::post('{slug}/verify-payment', [Controller::class, 'verifyPayment'])->middleware('permission:order-edit');
        Route::post('{slug}/reject-payment', [Controller::class, 'rejectPayment'])->middleware('permission:order-edit');

        // Status history
        Route::get('{slug}/history', [Controller::class, 'getHistory'])->middleware('permission:order-details|order-edit');

        // Delivery
        Route::post('{slug}/deliver', [Controller::class, 'deliver'])->middleware('permission:order-edit');

        // Admin note
        Route::post('{slug}/add-note', [Controller::class, 'addNote'])->middleware('permission:order-edit');

        // Admin payment proof
        Route::post('{slug}/add-payment', [Controller::class, 'addAdminPayment'])->middleware('permission:order-edit');

        // Toggle active/inactive (row visibility)
        Route::post('update-status', [Controller::class, 'updateStatus'])->middleware('permission:order-edit');

        // Soft delete / restore / hard delete / bulk
        Route::post('soft-delete', [Controller::class, 'softDelete'])->middleware('permission:order-delete');
        Route::post('destroy/{slug}', [Controller::class, 'destroy'])->middleware('permission:order-delete');
        Route::post('restore', [Controller::class, 'restore'])->middleware('permission:order-delete');
        Route::post('bulk-action', [Controller::class, 'bulkAction'])->middleware('permission:order-delete');

        // Import
        Route::post('import', [Controller::class, 'import'])->middleware('permission:order-import');
    });
});
