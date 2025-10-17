<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

class MainController extends Controller
{
    public function index(): void
    {
        $user = Auth::user();

        if ($user) {
            $this->redirect('/home');
        } else {
            $this->redirect('/guest');
        }
    }
}
