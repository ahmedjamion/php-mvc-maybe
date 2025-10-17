<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

class HomeController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $user = Auth::user();

        $homeContent = $this->renderPartial('home/home', ['user' => $user]);

        $this->view('main', [
            'title' => 'Home',
            'user' => $user ?? null,
            'content' => $homeContent,
        ]);
    }
}
