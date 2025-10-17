<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Flash;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }

        $this->renderPage('auth/login', ['title' => 'Login'], 'Login');
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            Flash::set('error', 'Email and password are required.');
            $this->redirect('/login');
            return;
        }

        $user = User::findByEmail($email);

        if (!$user || !$user->verifyPassword($password)) {
            Flash::set('error', 'Invalid email or password.');
            $this->redirect('/login');
            return;
        }

        Session::regenerate();

        $_SESSION['user_id'] = $user->id;

        Flash::set('success', 'Login success, welcome.');

        $this->redirect('/');
    }

    public function showRegister(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }

        $this->renderPage('auth/register', ['title' => 'Register'], 'Register');
    }

    public function register(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm'] ?? '');

        if ($name === '' || $email === '' || $password === '' || $confirm === '') {
            Flash::set('error', 'All fields are required.');
            $this->redirect('/register');
            return;
        }

        if ($password !== $confirm) {
            Flash::set('error', 'Passwords do not match.');
            $this->redirect('/register');
            return;
        }

        if (User::findByEmail($email)) {
            Flash::set('error', 'Email is already registered.');
            $this->redirect('/register');
            return;
        }

        $user = User::create($name, $email, $password);

        if (!$user) {
            Flash::set('error', 'Registration failed.');
            $this->redirect('/register');
            return;
        }

        Flash::set('success', 'Registration success, you can now login.');
        $this->redirect('/login');
    }

    public function logout(): void
    {
        Flash::set('success', 'Logout success.');
        Session::destroy();
        $this->redirect('/');
    }
}
