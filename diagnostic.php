<?php

// Setup Laravel
$app = require __DIR__ . '/bootstrap/app.php';

echo "=== Diagnostic Test ===\n\n";

try {
    // Test 1: Check Laravel app
    echo "[1] Laravel app initialized\n";
    
    // Test 2: Check if Pdf facade exists
    if (class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
        echo "[OK] DomPDF Facade exists\n";
    } else {
        echo "[ERROR] DomPDF Facade not found\n";
    }
    
    // Test 3: Check if DomPDF class exists
    if (class_exists('Dompdf\Dompdf')) {
        echo "[OK] DomPDF class exists\n";
    } else {
        echo "[ERROR] DomPDF class not found\n";
    }
    
    // Test 4: Try to create simple PDF
    echo "\n[2] Testing PDF creation...\n";
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml('<h1>Test</h1>');
    $dompdf->render();
    echo "[OK] PDF rendered successfully\n";
    
} catch (\Exception $e) {
    echo "[ERROR] " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}

?>
