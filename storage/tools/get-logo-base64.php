<?php

// Convert logo to base64
// Update path sesuai lokasi logo Anda
$logoPath = dirname(__DIR__, 2) . '/public/logo/logo-univ.png';

if (file_exists($logoPath)) {
    $imageData = file_get_contents($logoPath);
    $base64 = base64_encode($imageData);
    echo $base64;
} else {
    echo "File not found: $logoPath";
}

?>
