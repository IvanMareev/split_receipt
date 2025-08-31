<?php

use App\Http\Controllers\BillController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/telegram', [AuthController::class, 'telegramAuth']);

// публичные маршруты (без токена)
Route::get('/bills', [BillController::class, 'index']);
Route::get('/bills/{bill}', [BillController::class, 'show']);

// защищённые маршруты (нужен Bearer токен)

Route::post('/bills', [BillController::class, 'store']);
Route::put('/bills/{bill}', [BillController::class, 'update']);
Route::delete('/bills/{bill}', [BillController::class, 'destroy']);


// Laravel автоматически редиректит на "login", если не авторизован
Route::get('/login', function () {
    return response()->json(['message' => 'Unauthenticated'], 401);
})->name('login');
