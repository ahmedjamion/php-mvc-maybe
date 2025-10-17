<?php

use App\Core\Flash;

$flashes = Flash::all();

?>

<?php foreach ($flashes as $type => $message): ?>
    <p class="flash <?= $type ?>">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endforeach; ?>