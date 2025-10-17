<?php

declare(strict_types=1);

return [
    'app' => [
        'env' => $_ENV['APP_ENV'] ?? 'local',
        'debug' => isset($_ENV['APP_DEBUG']) && in_array(strtolower((string)$_ENV['APP_DEBUG']), ['1', 'true', 'yes'], true),
        'url' => $_ENV['APP_URL'] ?? 'http://localhost:8000',
    ],
    'database' => [
        'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
        'name' => $_ENV['DB_NAME'] ?? 'myapp',
        'user' => $_ENV['DB_USER'] ?? 'root',
        'pass' => $_ENV['DB_PASS'] ?? '',
        'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
    ],
    'paths' => [
        'storage' => __DIR__ . '/../storage',
        'logs' => __DIR__ . '/../storage/logs',
    ],
];
