<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        // Разрешенные домены
        $allowedOrigins = [
            'https://jubilant-cod-wrv454vqq7q5c95wr-9000.app.github.dev',
            'http://localhost:3000',
            'http://localhost:5173',
        ];

        $origin = $request->header('Origin');

        // Если Origin есть в списке разрешенных
        if (in_array($origin, $allowedOrigins)) {
            // Для OPTIONS запросов (preflight)
            if ($request->isMethod('OPTIONS')) {
                return response()->json('OK', 200)
                    ->header('Access-Control-Allow-Origin', $origin)
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                    ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-CSRF-TOKEN')
                    ->header('Access-Control-Allow-Credentials', 'true');
            }

            // Для обычных запросов
            $response = $next($request);
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-CSRF-TOKEN');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');

            return $response;
        }

        return $next($request);
    }
}