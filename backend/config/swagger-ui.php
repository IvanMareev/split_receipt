<?php

use Wotz\SwaggerUi\Http\Middleware\EnsureUserIsAuthorized;

return [
    'files' => [
        [
            'path' => 'swagger',
            'title' => env('APP_NAME') . ' - Swagger',
            'versions' => [
                'v1' => public_path('docs/openapi.yaml'), // файл реально существует
            ],
            'default' => 'v1',
            'middleware' => ['web'], // убрали авторизацию для теста
            'validator_url' => false,
            'modify_file' => true,
            'server_url' => env('APP_URL'),
            'oauth' => [
                'token_path' => '',
                'refresh_path' => '',
                'authorization_path' => '',
                'client_id' => '',
                'client_secret' => '',
            ],
            'stylesheet' => null,
        ],
    ],

];
