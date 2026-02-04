<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EwalletController;

Route::get('/home', function (Request $request) {
    return 'Hello World';
})->name('home');

Route::post('/login',[AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/check-profile', [AuthController::class, 'checkProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/ewallet', [EwalletController::class, 'test']);
    Route::post('/create-ewallet', [EwalletController::class, 'create']);
    Route::post('/topup', [EwalletController::class, 'topup']);

});
