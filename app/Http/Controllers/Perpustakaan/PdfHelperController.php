<?php

namespace App\Http\Controllers\Perpustakaan;

use App\Http\Controllers\Controller;

class PdfHelperController extends Controller
{
    public function getLogoBase64()
    {
        $logoPath = public_path('logo/logo-univ.png');
        
        if (file_exists($logoPath)) {
            $imageData = file_get_contents($logoPath);
            $base64 = base64_encode($imageData);
            return response()->json(['base64' => $base64]);
        }
        
        return response()->json(['error' => 'Logo not found'], 404);
    }
}
