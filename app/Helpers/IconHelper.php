<?php

declare(strict_types=1);

/**
 * Renders an SVG icon by reading its file content and inlining the markup.
 *
 * @param string $name The filename of the SVG (e.g., 'home' for 'home.svg').
 * @param array $attrs Optional attributes to add to the <svg> tag 
 * (e.g., ['class' => 'icon-lg text-primary']).
 * @return void
 */
function svg_icon(string $name, array $attrs = []): void
{
    // Path: app/Helpers/IconHelper.php -> ../../public/assets/icons/
    $path = __DIR__ . '/../../public/assets/icons/' . strtolower($name) . '.svg';

    if (!file_exists($path)) {
        // Output an HTML comment for debugging when icon is not found
        echo "<!-- ERROR: SVG icon '{$name}.svg' not found. -->";
        return;
    }

    // Load the SVG content
    $svg_markup = file_get_contents($path);

    // Prepare attributes string (HTML-encode keys and values for safety)
    $attr_string = '';
    foreach ($attrs as $key => $value) {
        $safe_key = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
        $safe_value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        $attr_string .= " {$safe_key}=\"{$safe_value}\"";
    }

    // Inject attributes immediately after the opening '<svg' tag
    // We assume all SVGs start with '<svg' (4 characters)
    $final_svg = substr_replace($svg_markup, $attr_string, 4, 0);

    // Output the final inlined SVG markup
    echo $final_svg;
}
