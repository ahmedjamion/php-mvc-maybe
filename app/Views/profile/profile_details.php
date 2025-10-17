<div class="profile-detail-group">
    <p class="profile-detail-label">Id:</p>
    <p class="profile-detail"><?= htmlspecialchars($user->id) ?></p>
</div>
<div class="profile-detail-group">
    <p class="profile-detail-label">Name:</p>
    <p class="profile-detail"><?= htmlspecialchars($user->name) ?></p>
</div>
<div class="profile-detail-group">
    <p class="profile-detail-label">Email</p>
    <p class="profile-detail"><?= htmlspecialchars($user->email) ?></p>
</div>
<a href="/profile/settings" class="primary-button">Edit</a>