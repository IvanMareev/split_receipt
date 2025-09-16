<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::post('/auth/telegram', [AuthController::class, 'telegramAuth']);

// Laravel автоматически редиректит на "login", если не авторизован
Route::get('/login', function () {
    return response()->json(['message' => 'Unauthenticated'], 401);
})->name('login');
