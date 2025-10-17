<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    protected array $routes = [];
    protected array $currentRoute = [];

    public function get(string $pattern, $handler): void
    {
        $this->add('GET', $pattern, $handler);
    }

    public function post(string $pattern, $handler): void
    {
        $this->add('POST', $pattern, $handler);
    }

    public function add(string $method, string $pattern, $handler): void
    {
        $this->routes[] = ['method' => strtoupper($method), 'pattern' => $pattern, 'handler' => $handler];
    }

    public function dispatch(string $uri, string $method): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($method)) {
                continue;
            }

            $regex = "@^" . preg_replace('#\{([\w]+)\}#', '(?P<$1>[^/]+)', $route['pattern']) . "$@";

            if (preg_match($regex, $path, $matches)) {
                $segments = array_filter(explode('/', $route['pattern']));
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->currentRoute = array_merge($segments, array_values($params));

                $handler = $route['handler'];

                if (is_callable($handler)) {
                    call_user_func_array($handler, $params);
                    return;
                }

                if (is_string($handler) && strpos($handler, '@') !== false) {
                    [$controller, $action] = explode('@', $handler);
                    $class = 'App\\Controllers\\' . $controller;

                    if (!class_exists($class)) {
                        http_response_code(500);
                        echo "Controller {$class} not found";
                        return;
                    }

                    $instance = new $class($this);

                    if (!method_exists($instance, $action)) {
                        http_response_code(500);
                        echo "Action {$action} not found on {$class}";
                        return;
                    }

                    call_user_func_array([$instance, $action], $params);
                    return;
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    public function getCurrentRoute(): array
    {
        return $this->currentRoute;
    }

    public function getCurrentTopLevel(): string
    {
        return $this->currentRoute[0] ?? '';
    }
}
