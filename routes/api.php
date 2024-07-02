<?php

use App\Http\Controllers\Api\SessionController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return UserResource::make($request->user());
})->middleware('auth:sanctum');

Route::middleware('guest')->group(function () {
    Route::post('/login', [SessionController::class, "login"]);
    Route::post('/register', [SessionController::class, "register"]);
});
