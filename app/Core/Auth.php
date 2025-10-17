<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;

class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function user(): ?User
    {
        if (!self::check()) {
            return null;
        }

        static $user = null;

        if ($user === null) {
            $user = User::findById((int) $_SESSION['user_id']);
        }

        return $user;
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }
}
