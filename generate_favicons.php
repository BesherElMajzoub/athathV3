<?php
// Generate simple SVG favicon and copy OG image as apple-touch-icon
// Run: php artisan tinker --execute="require 'generate_favicons.php';"

// Create a simple SVG favicon
$svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
  <rect width="32" height="32" rx="8" fill="#2F6B3F"/>
  <text x="16" y="22" font-size="18" text-anchor="middle" fill="white">🪑</text>
</svg>
SVG;

file_put_contents(__DIR__ . '/public/favicon.svg', $svg);

// Use GD to create png favicons if available
if (extension_loaded('gd')) {
    // 32x32 favicon
    $img = imagecreatetruecolor(32, 32);
    $green = imagecolorallocate($img, 47, 107, 63);
    $white = imagecolorallocate($img, 255, 255, 255);
    imagefill($img, 0, 0, $green);
    imagepng($img, __DIR__ . '/public/favicon-32x32.png');

    // 180x180 apple touch icon
    $img2 = imagecreatetruecolor(180, 180);
    $green2 = imagecolorallocate($img2, 47, 107, 63);
    imagefill($img2, 0, 0, $green2);
    imagepng($img2, __DIR__ . '/public/apple-touch-icon.png');

    imagedestroy($img);
    imagedestroy($img2);
    echo "Favicons generated!\n";
} else {
    echo "GD not available, SVG favicon only.\n";
}
