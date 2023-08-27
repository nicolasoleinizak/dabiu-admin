<?php

use App\Http\Controllers\ProductController;

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index');
    });
});
