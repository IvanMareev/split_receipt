<?php

use App\Http\Controllers\Api\BillController;
use Illuminate\Support\Facades\Route;


Route::get('/bills', [BillController::class, 'index']); // Маршрут для получения всех счетов
Route::post('/bills', [BillController::class, 'store']); // Маршрут для создания счета
Route::get('/bills/{bill}', [BillController::class, 'show']); // Маршрут для получения одного счета
Route::put('/bills/{bill}', [BillController::class, 'update']); // Маршрут для обновления счета
Route::delete('/bills/{bill}', [BillController::class, 'destroy']); // Маршрут для удаления счета