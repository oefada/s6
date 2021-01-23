<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreativeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::resources([
        'creatives' => CreativeController::class,
    ]);

    Route::post('creatives/{id}/listForSale', [CreativeController::class, 'listForSale']);
    Route::get('shop', [CustomerController::class, 'shop']);
    Route::post('shop/placeOrder', [CustomerController::class, 'placeOrder']);
});

Route::middleware('auth:sanctum')->prefix('vendor')->group(function () {
    Route::get('orders', [VendorController::class, 'orders']);
    Route::post('orders', [VendorController::class, 'orderUpdate']);
});
