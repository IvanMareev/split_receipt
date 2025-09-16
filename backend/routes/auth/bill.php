<?php

use App\Http\Controllers\BillController;
use Illuminate\Support\Facades\Route;

Route::get('/bills', [BillController::class, 'index']);
Route::get('/bills/{bill}', [BillController::class, 'show']);

// защищённые маршруты (нужен Bearer токен)

Route::post('/bills', [BillController::class, 'store']);
Route::put('/bills/{bill}', [BillController::class, 'update']);
Route::delete('/bills/{bill}', [BillController::class, 'destroy']);



