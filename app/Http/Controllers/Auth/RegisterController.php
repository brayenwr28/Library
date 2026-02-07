<?php

namespace App\Http\Controllers\Auth;

use App\Models\Member;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class RegisterController
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();

        // Generate member_id (nomor anggota pustaka)
        $member_id = 'PUS' . date('Y') . str_pad(Member::count() + 1, 5, '0', STR_PAD_LEFT);

        // Ambil signature dan stamp dari member pertama (admin)
        $adminMember = Member::first();
        
        $member = Member::create([
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nim' => $validated['nim'],
            'prodi' => $validated['prodi'],
            'member_id' => $member_id,
            'tgl_daftar' => now(),
            'signature_path' => $adminMember ? $adminMember->signature_path : null,
            'stamp_path' => $adminMember ? $adminMember->stamp_path : null,
        ]);

        // Redirect ke halaman kartu pustaka
        return redirect()->route('member.card', $member->id);
    }

    public function card($id)
    {
        $member = Member::findOrFail($id);
        return view('auth.member-card', compact('member'));
    }

    public function downloadPdf($id)
    {
        try {
            // Validasi system requirements
            $this->validateSystemRequirements();
            
            $member = Member::findOrFail($id);
            
            // Validasi member data
            if (!$member->member_id || !$member->name) {
                throw new \Exception('Data anggota tidak lengkap. Hubungi admin.');
            }
            
            // Convert images to base64
            $logoBase64 = $this->getImageBase64(public_path('logo/logo-univ.png'), 'png');
            $stempelBase64 = $this->getImageBase64(public_path('images/stempel.jpg'), 'jpeg');
            $ttdBase64 = $this->getImageBase64(public_path('images/ttddigital.jpg'), 'jpeg');
            
            // Generate PDF
            $pdf = Pdf::loadView('auth.member-card-pdf', [
                'member' => $member,
                'logoBase64' => $logoBase64,
                'stempelBase64' => $stempelBase64,
                'ttdBase64' => $ttdBase64
            ]);
            
            $filename = 'kartu-pustaka-' . $member->member_id . '-' . date('YmdHis') . '.pdf';
            
            Log::info('PDF download success', [
                'member_id' => $member->id,
                'member_name' => $member->name,
                'filename' => $filename
            ]);
            
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            Log::error('PDF Download Error', [
                'member_id' => $id ?? 'unknown',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            $errorMessage = $this->getUserFriendlyError($e->getMessage());
            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Validate system requirements untuk PDF generation
     */
    private function validateSystemRequirements()
    {
        // Check GD Extension
        if (!extension_loaded('gd')) {
            throw new \Exception('GD Extension tidak aktif. Hubungi admin untuk mengaktifkannya.');
        }
        
        // Check required directories exist
        $requiredDirs = [
            public_path('logo'),
            public_path('images'),
            storage_path('fonts'),
        ];
        
        foreach ($requiredDirs as $dir) {
            if (!is_dir($dir)) {
                Log::warning('Required directory missing: ' . $dir);
            }
        }
        
        // Check writable storage
        if (!is_writable(storage_path())) {
            throw new \Exception('Storage tidak dapat ditulis. Hubungi admin.');
        }
    }

    /**
     * Convert image ke base64 dengan error handling
     */
    private function getImageBase64($path, $type)
    {
        try {
            if (!file_exists($path)) {
                Log::warning('Image file not found: ' . $path);
                return '';
            }
            
            // Check file size (max 5MB)
            $fileSize = filesize($path);
            if ($fileSize > 5242880) { // 5MB
                Log::warning('Image file too large: ' . $path);
                return '';
            }
            
            // Check if file is readable
            if (!is_readable($path)) {
                Log::warning('Image file not readable: ' . $path);
                return '';
            }
            
            $imageData = file_get_contents($path);
            if ($imageData === false) {
                Log::warning('Failed to read image: ' . $path);
                return '';
            }
            
            return 'data:image/' . $type . ';base64,' . base64_encode($imageData);
            
        } catch (\Exception $e) {
            Log::warning('Error processing image: ' . $path, [
                'error' => $e->getMessage()
            ]);
            return '';
        }
    }

    /**
     * Konversi technical error ke user-friendly message
     */
    private function getUserFriendlyError($technicalError)
    {
        $errorMap = [
            'GD Extension' => 'Fitur PDF belum diaktifkan. Hubungi administrator.',
            'not found' => 'File yang diperlukan tidak ditemukan. Hubungi administrator.',
            'cannot be opened' => 'File rusak atau tidak dapat dibaca. Hubungi administrator.',
            'Storage tidak dapat ditulis' => 'Sistem penyimpanan bermasalah. Hubungi administrator.',
            'Data anggota tidak lengkap' => 'Data anggota Anda tidak lengkap. Silakan update profil Anda.',
        ];
        
        foreach ($errorMap as $key => $message) {
            if (stripos($technicalError, $key) !== false) {
                return $message;
            }
        }
        
        return 'Terjadi kesalahan saat membuat PDF. Silakan coba lagi atau hubungi administrator.';
    }
}
