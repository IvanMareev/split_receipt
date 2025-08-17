<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function telegramAuth(Request $request)
    {
        $data = $request->all();

        // Telegram присылает вложенный объект user — расплющиваем его
        if (isset($data['user']) && is_array($data['user'])) {
            $data = array_merge($data, $data['user']);
            unset($data['user']);
        }

        // Секретный ключ для проверки подписи
        $secretKey = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);

        // Формируем строку для хеша
        $checkString = collect($data)
            ->except('hash') // hash исключаем
            ->map(fn($value, $key) => $key . '=' . $value)
            ->sort()
            ->implode("\n");

        $calculatedHash = hash_hmac('sha256', $checkString, $secretKey);

        // if (!hash_equals($calculatedHash, $data['hash'] ?? '')) {
        //     return response()->json(['error' => 'Invalid data'], 401);
        // }

        // Находим или создаём пользователя
        $user = User::firstOrCreate(
            ['telegram_id' => $data['id']],
            [
                'name' => $data['first_name'] ?? '',
                'username' => $data['username'] ?? null,
                'last_name' => $data['last_name'] ?? null,
                'photo_url' => $data['photo_url'] ?? null,
            ]
        );

        // Генерируем Sanctum токен
        $token = $user->createToken('webapp')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
