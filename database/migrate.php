<?php

declare(strict_types=1);

/**
 * Script for creating database and tables
 * 
 * Usage: php database/migrate.php
 */
require __DIR__ . '/../config/env.php';

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$db   = $_ENV['DB_NAME'] ?? 'myapp';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

$dsn = "mysql:host={$host};charset={$charset}";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connected to MySQL server at {$host}\n";

    $pdo->exec("
        CREATE DATABASE IF NOT EXISTS `{$db}`
        CHARACTER SET {$charset}
        COLLATE {$charset}_unicode_ci
    ");

    echo "Database `{$db}` ensured.\n";

    $pdo->exec("USE `{$db}`");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET={$charset} COLLATE={$charset}_unicode_ci
    ");
    echo "Table `users` ensured.\n";

    echo "Migration complete.\n";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
