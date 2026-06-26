<?php

use Illuminate\Support\Facades\Route;
use Modules\Controllers\Frontend\Auth\AuthController;
use Modules\Controllers\Frontend\FrontendController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontendController::class, 'HomePage'])->name('HomePage');
Route::get('/login', [AuthController::class, 'LoginPage'])->name('LoginPage');
Route::get('/forgot-password', [AuthController::class, 'ForgotPassword'])->name('ForgotPassword');
Route::get('/todo', [FrontendController::class, 'TodoPage'])->name('TodoPage');
Route::get('/transactions', [FrontendController::class, 'TransactionPage'])->name('TransactionPage');
Route::get('/products', [FrontendController::class, 'ProductsPage'])->name('ProductsPage');
Route::get('/products/{slug}', [FrontendController::class, 'ProductDetailsPage'])->name('ProductDetailsPage');
Route::get('/products/{slug}/payment', [FrontendController::class, 'ProductPaymentPage'])->name('ProductPaymentPage');
Route::get('/blog',        [FrontendController::class, 'BlogsPage'])->name('BlogsPage');
Route::get('/blog/{slug}', [FrontendController::class, 'BlogDetailsPage'])->name('BlogDetailsPage');