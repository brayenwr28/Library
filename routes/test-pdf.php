<?php

use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/test-pdf', function () {
    try {
        $html = '<html><body><h1>Test PDF</h1><p>Jika Anda melihat ini, DomPDF bekerja!</p></body></html>';
        $pdf = Pdf::loadHTML($html);
        return $pdf->download('test.pdf');
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }
});
