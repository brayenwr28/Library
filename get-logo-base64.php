<?php

// Convert logo to base64
$logoPath = 'd:\Perpus_Digital\public\logo\logo-univ.png';

if (file_exists($logoPath)) {
    $imageData = file_get_contents($logoPath);
    $base64 = base64_encode($imageData);
    echo $base64;
} else {
    echo "File not found: $logoPath";
}

?>
