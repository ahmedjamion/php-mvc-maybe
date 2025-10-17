<?php

declare(strict_types=1);

$envFile = __DIR__ . '/../.env';
if (!file_exists($envFile)) {
    return;
}

$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '' || $line[0] === '#') {
        continue;
    }

    $parts = explode('=', $line, 2);
    if (count($parts) !== 2) {
        continue;
    }

    $key = trim($parts[0]);
    $value = trim($parts[1]);

    if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
        (substr($value, 0, 1) === "'" && substr($value, -1) === "'")
    ) {
        $value = substr($value, 1, -1);
    }

    $_ENV[$key] = $value;
    putenv("$key=$value");
}
