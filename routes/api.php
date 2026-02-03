<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::get('/home', function (Request $request) {
    return 'Hello World';
})->name('home');

Route::post('/login',[AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/check-profile', [AuthController::class, 'checkProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //

});
