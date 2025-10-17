<?php

use App\Core\Auth;

?>

<?php if (Auth::user()): ?>
    <input type="checkbox" name="sidebar-toggle" id="sidebarToggle" hidden>
    <label for="sidebarToggle" class="sidebar-toggle">
        <?= svg_icon('panel-right', [
            'width' => '20',
            'stroke-width' => '2'
        ]) ?>
    </label>
    <label for="sidebarToggle" class="overlay"></label>
    <div class="sidebar">
        <div class="sidebar-top">
            <nav class="sidenav">
                <a href="/home" class="sidenav-item <?= $route === 'home' ? 'route-active' : 'route-inactive' ?>">
                    <?= svg_icon('house', [
                        'width' => '20',
                        'stroke-width' => '2'
                    ]) ?>
                    <span class="sidenav-item-text">Home</span>
                </a>
                <a href="/profile" class="sidenav-item <?= $route === 'profile' ? 'route-active' : 'route-inactive' ?>">
                    <?= svg_icon('user-round', [
                        'width' => '20',
                        'stroke-width' => '2'
                    ]) ?>
                    <span class="sidenav-item-text">Profile</span>
                </a>
                <a href="/settings" class="sidenav-item <?= $route === 'settings' ? 'route-active' : 'route-inactive' ?>">
                    <?= svg_icon('sliders-horizontal', [
                        'width' => '20',
                        'stroke-width' => '2'
                    ]) ?>
                    <span class="sidenav-item-text">Settings</span>
                </a>
            </nav>
        </div>
        <a href="/logout" class="logout-link">
            <?= svg_icon('log-out', [
                'width' => '20',
                'stroke-width' => '2'
            ]) ?>
            <span class="logout-text">Logout</span>
        </a>
    </div>
<?php endif; ?>