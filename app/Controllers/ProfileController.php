<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

class ProfileController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        $this->redirect('/profile/details');
        return;
    }

    public function profileDetails(): void
    {
        Auth::requireLogin();

        $user = Auth::user();

        $detailsContent = $this->renderPartial('profile/profile_details', [
            'user' => $user,
        ]);

        $this->renderPage('profile/profile', [
            'user' => $user,
            'content' => $detailsContent,
        ], 'Profile');
    }

    public function profileSettings(): void
    {
        Auth::requireLogin();

        $user = Auth::user();

        $settingsContent = $this->renderPartial('profile/profile_settings', [
            'user' => $user,
        ]);

        $this->renderPage('profile/profile', [
            'user' => $user,
            'content' => $settingsContent,
        ], 'Profile');
    }
}
