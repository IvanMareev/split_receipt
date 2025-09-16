<?php

use App\Http\Controllers\BillItemsController;
use Illuminate\Support\Facades\Route;

Route::get('/bills-items/{bill}/items', [BillItemsController::class, 'getBillItems']);

Route::get('/bills-items', [BillItemsController::class, 'index']);
Route::get('/bills-items/{bill}', [BillItemsController::class, 'show']);

// защищённые маршруты (нужен Bearer токен)

Route::post('/bills-items', [BillItemsController::class, 'store']);
Route::put('/bills-items/{bill}', [BillItemsController::class, 'update']);
Route::delete('/bills-items/{bill}', [BillItemsController::class, 'destroy']);
