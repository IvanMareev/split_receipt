<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatisticBillController;

// Подсчёт счетов за диапазон и статус
Route::get('/bills/statistic/count/{range}/{status?}', [StatisticBillController::class, 'countAllBill']);

// Сумма всех счетов за диапазон
Route::get('/bills/statistic/sum/{range}/{status?}', [StatisticBillController::class, 'sumBills']);

// Средняя сумма счета за диапазон
Route::get('/bills/statistic/average/{range}/{status?}', [StatisticBillController::class, 'averageBill']);

// Количество счетов по каждому статусу за диапазон
Route::get('/bills/statistic/count-by-status/{range}', [StatisticBillController::class, 'countByStatus']);

// Количество счетов по дням (тренд) за диапазон и статус
Route::get('/bills/statistic/daily/{range}/{status?}', [StatisticBillController::class, 'dailyCount']);

// Минимальная и максимальная сумма счетов за диапазон и статус
Route::get('/bills/statistic/min-max/{range}/{status?}', [StatisticBillController::class, 'minMaxBill']);
