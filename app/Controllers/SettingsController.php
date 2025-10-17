<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

class SettingsController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $user = Auth::user();

        $content = $this->renderPartial('settings/settings', ['user' => $user]);

        $this->view('main', [
            'title' => 'Settings',
            'user' => $user ?? null,
            'content' => $content,
        ]);
    }
}
