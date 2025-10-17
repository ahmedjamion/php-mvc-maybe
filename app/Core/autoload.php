<?php

declare(strict_types=1);

$baseDir = __DIR__ . '/..';

spl_autoload_register(function (string $class) use ($baseDir): void {
    $prefix = 'App\\';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $file = $baseDir . '/' . str_replace('\\', '/', $relative) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

require_once __DIR__ . '/../Helpers/IconHelper.php';
