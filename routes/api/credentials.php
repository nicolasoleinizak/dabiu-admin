<?php

use App\Http\Controllers\WCCredentialController;

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(WCCredentialController::class)->group(function () {
        Route::post('/credentials/wc', 'create');
        Route::get('/credentials/wc/check', 'check');
        Route::delete('/credentials/wc', 'delete');
    });
});
