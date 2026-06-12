<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;

$member = Member::whereNotNull('photo')->first();
if (!$member) {
    echo "NO_MEMBER\n";
    return;
}

echo "member_id=" . $member->member_id . "\n";
echo "photo=" . $member->photo . "\n";
$photoPath = storage_path('app/public/' . $member->photo);
echo "photoPath=" . $photoPath . "\n";
echo "photoExists=" . (file_exists($photoPath) ? 'OK' : 'MISSING') . "\n";
$logoPath = public_path('logo/logo-univ.png');
echo "logoPath=" . $logoPath . "\n";
echo "logoExists=" . (file_exists($logoPath) ? 'OK' : 'MISSING') . "\n";

if (file_exists($photoPath) && file_exists($logoPath)) {
    $photoBase64 = 'data:' . mime_content_type($photoPath) . ';base64,' . base64_encode(file_get_contents($photoPath));
    $logoBase64 = 'data:' . mime_content_type($logoPath) . ';base64,' . base64_encode(file_get_contents($logoPath));
    $pdf = Pdf::loadView('KartuAnggota.pdf', [
        'member' => $member,
        'photoBase64' => $photoBase64,
        'logoBase64' => $logoBase64,
    ]);
    file_put_contents(storage_path('app/test-ktm.pdf'), $pdf->output());
    echo "pdf_saved=" . storage_path('app/test-ktm.pdf') . "\n";
}
