<?php

use App\Http\Controllers\WCCredentialController;

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(WCCredentialController::class)->group(function () {
        Route::post('/credentials/wc', 'create');
    });
});
