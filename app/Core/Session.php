<?php

declare(strict_types=1);

namespace App\Core;

final class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        if (headers_sent()) {
            throw new \RuntimeException('Cannot start session: headers already sent.');
        }

        ini_set('session.use_only_cookies', '1');
        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_trans_sid', '0');
        ini_set('session.cookie_httponly', '1');
        ini_set('session.use_cookies', '1');

        $host = $_SERVER['HTTP_HOST'] ?? '';
        $host = preg_replace('/:\d+$/', '', $host);
        $cookieParams = [
            'lifetime' => 1800,
            'path'     => '/',
            'domain'   => $host,
            'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
            'httponly' => true,
            'samesite' => 'Lax',

        ];

        session_name('APPSESSID');
        session_set_cookie_params($cookieParams);

        if (!session_start()) {
            throw new \RuntimeException('Session start failed.');
        }

        self::enforceTimeout($cookieParams['lifetime']);
        self::maybeRegenerate(600);
    }

    public static function regenerate(): void
    {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
        $_SESSION['fingerprint'] = self::generateFingerprint();
    }

    private static function generateFingerprint(): string
    {
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        return hash('sha256', $ua);
    }

    private static function maybeRegenerate(int $maxAge): void
    {
        if (!isset($_SESSION['last_regeneration'])) {
            self::regenerate();
            return;
        }

        if (time() - (int)$_SESSION['last_regeneration'] >= $maxAge) {
            self::regenerate();
        }
    }

    private static function enforceTimeout(int $lifetime): void
    {
        if (
            isset($_SESSION['LAST_ACTIVITY']) &&
            (time() - $_SESSION['LAST_ACTIVITY']) > $lifetime
        ) {
            self::destroy();
            session_start();
        }
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    public static function isValid(): bool
    {
        if (!isset($_SESSION['fingerprint'])) {
            return false;
        }
        return hash_equals($_SESSION['fingerprint'], self::generateFingerprint());
    }

    public static function destroy(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                (bool)$params['secure'],
                (bool)$params['httponly']
            );
        }
        session_destroy();
    }
}
