<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RayonController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('rayons', RayonController::class);
    });


    
    
    Route::get('/products/search', [ProductController::class, 'search']);
    Route::get('/products/popular-or-on-sale', [ProductController::class, 'popularOrOnSale']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);

    Route::apiResource('sales', SaleController::class);
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    });
});
