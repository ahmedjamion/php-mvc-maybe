<?php

declare(strict_types=1);

namespace App\Core;

class Flash
{
    public static function set(string $key, string $message): void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['flash'][$key] = $message;
    }

    public static function get(string $key): ?string
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['flash'][$key])) {
            $msg = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $msg;
        }
        return null;
    }

    public static function all(): array
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $messages = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $messages;
    }
}
