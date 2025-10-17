<?php

declare(strict_types=1);

?>
<div class="login-page">
    <h2><?= htmlspecialchars($title ?? 'Login', ENT_QUOTES, 'UTF-8') ?></h2>

    <form method="POST" action="/login" class="login-form">
        <div class="input-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" placeholder="example@gmail.com" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="Password" required>
        </div>

        <input type="submit" value="Login">
    </form>

    <div class="row">
        <a href="/register" class="primary-button">Register</a>
        <a href="/" class="secondary-button">Home</a>
    </div>
</div>