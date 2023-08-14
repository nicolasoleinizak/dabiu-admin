<?php

use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
    Route::post('/register', 'register');
});
