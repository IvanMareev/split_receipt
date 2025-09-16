<?php

foreach (glob(__DIR__ . '/auth/*.php') as $file) {
    require $file;
}


foreach (glob(__DIR__ . '/public/*.php') as $file) {
    require $file;
}

// авторизованные маршруты
Route::middleware('auth:sanctum')->group(function () {
    foreach (glob(__DIR__ . '/auth/*.php') as $file) {
        require $file;
    }
});