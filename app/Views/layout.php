<?php

declare(strict_types=1);

$route = $router->getCurrentTopLevel();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/manifest.json">
    <link rel="stylesheet" href="/styles/styles.css?v=<?php echo time(); ?>">
    <title><?= htmlspecialchars($title ?? 'My App', ENT_QUOTES, 'UTF-8') ?></title>
</head>

<body>
    <?php include __DIR__ . '/sidebar.php'; ?>

    <?= $content ?? '' ?>

    <?php include __DIR__ . '/flash.php'; ?>
</body>

<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('Service Worker registered', reg))
            .catch(err => console.error('Service Worker registration failed', err));
    }
</script>

</html>