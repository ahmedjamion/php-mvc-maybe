<?php

declare(strict_types=1);

?>

<div class="register-page">
    <h1><?= htmlspecialchars($title ?? 'Register', ENT_QUOTES, 'UTF-8') ?></h1>

    <form method="POST" action="/register" class="register-form">
        <div class="input-group">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" placeholder="John Doe" required>
        </div>

        <div class="input-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" placeholder="johndoe@gmail.com" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="At least 8 characters" minlength="8" required>
        </div>

        <div class="input-group">
            <label for="confirmPassword">Confirm Password</label>
            <input id="confirmPassword" type="password" name="confirm" placeholder="Re-type password" required>
        </div>

        <input type="submit" value="Register">
    </form>

    <div class="row">
        <a href="/login" class="primary-button">Login</a>
        <a href="/" class="secondary-button">Home</a>
    </div>
</div>