<?php

declare(strict_types=1);

namespace App\Core;

class Controller
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    protected function view(string $name, array $data = []): void
    {
        $data['router'] = $this->router;
        View::render($name, $data);
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    protected function json($data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    protected function renderPage(string $subview, array $data = [], string $pageTitle = ''): void
    {
        $user = $data['user'] ?? null;

        $content = $this->renderPartial($subview, $data);

        $this->view('main', [
            'user'    => $user,
            'content' => $content,
            'title'   => $pageTitle,
        ]);
    }

    protected function renderPartial(string $view, array $data = []): string
    {
        extract($data);
        ob_start();
        include __DIR__ . "/../Views/$view.php";
        return ob_get_clean();
    }
}
