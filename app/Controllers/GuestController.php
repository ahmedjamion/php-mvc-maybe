<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class GuestController extends Controller
{
    public function index(): void
    {
        $content = $this->renderPartial('guest/guest', ['user' => null]);

        $this->view('main', [
            'title' => 'Guest',
            'user' => $user ?? null,
            'content' => $content,
        ]);
    }
}
