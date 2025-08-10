<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function telegramAuth(Request $request)
    {
        $data = $request->all();

        $secretKey = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);

        $checkString = collect($data)
            ->except('hash')
            ->map(function ($value, $key) {
                return $key . '=' . $value;
            })
            ->sort()
            ->implode("\n");

        $hash = hash_hmac('sha256', $checkString, $secretKey);

        if (!hash_equals($hash, $data['hash'])) {
            return response()->json(['error' => 'Invalid data'], 401);
        }

        // Находим или создаём пользователя
        $user = User::firstOrCreate(
            ['telegram_id' => $data['id']],
            [
                'name' => $data['first_name'] ?? '',
                'username' => $data['username'] ?? null,
            ]
        );

        // Генерируем токен Sanctum
        $token = $user->createToken('webapp')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
