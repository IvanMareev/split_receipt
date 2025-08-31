<?php

use App\Http\Controllers\Api\BillController;
use Illuminate\Support\Facades\Route;

Route::post('/bills', [BillController::class, 'store']); // Используйте правильное имя метода

// Или если у вас метод называется Bill:
Route::post('/bills', [BillController::class, 'Bill']);
