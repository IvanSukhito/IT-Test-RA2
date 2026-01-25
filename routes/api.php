<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::get('/user', function (Request $request) {
    return 'Hello World';
});

Route::post('/login',[AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/check-profile', [AuthController::class, 'checkProfile']);
});
