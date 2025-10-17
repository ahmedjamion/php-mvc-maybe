<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "View not found: {$view}";
            return;
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        $layout = __DIR__ . '/../Views/layout.php';
        if (file_exists($layout)) {
            require $layout;
        } else {
            echo $content;
        }
    }
}
