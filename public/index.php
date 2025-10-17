<?php

declare(strict_types=1);

use App\Core\Router;
use App\Core\Session;

require __DIR__ . '/../app/Core/autoload.php';
require __DIR__ . '/../config/env.php';

$config = require __DIR__ . '/../config/app.php';

if ($config['app']['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    set_exception_handler(function (\Throwable $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo 'Server error';
    });
}

Session::start();

if (!Session::isValid()) {
    Session::destroy();
    header('Location: /login');
    exit;
}

$router = new Router();

require __DIR__ . '/../routes/routes.php';

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$router->dispatch($path, $method);
