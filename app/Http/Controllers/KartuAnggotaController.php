<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class KartuAnggotaController extends Controller
{
    public function index()
    {
        $member = Member::where('email', Auth::user()->email)->first();

        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Data member tidak ditemukan');
        }

        return view('KartuAnggota.index', ['member' => $member]);
    }

    public function downloadPDF()
    {
        $member = Member::where('email', Auth::user()->email)->first();

        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Data member tidak ditemukan');
        }

        try {
            $canRenderImages = extension_loaded('gd');

            if (!$canRenderImages) {
                Log::warning('KTM PDF generated without images because PHP GD extension is not installed.');
            }

            $photoBase64 = null;
            if ($canRenderImages && $member->photo) {
                $photoBase64 = $this->imageDataUri(storage_path('app/public/' . $member->photo));
            }

            $logoBase64 = $canRenderImages
                ? $this->imageDataUri(public_path('logo/logo-univ.png'))
                : null;

            // Generate PDF dengan dompdf
            $pdf = Pdf::loadView('KartuAnggota.pdf', [
                'member' => $member,
                'photoBase64' => $photoBase64,
                'logoBase64' => $logoBase64
            ])
                ->setPaper('a4')
                ->setOption('defaultFont', 'Arial')
                ->setOption('margin_left', 0)
                ->setOption('margin_right', 0)
                ->setOption('margin_top', 5)
                ->setOption('margin_bottom', 5)
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', false)
                ->setOption('isFontSubsettingEnabled', true);

            // Download dengan nama file KTM-{member_id}-{tanggal}.pdf
            $filename = 'KTM-' . $member->member_id . '-' . now()->format('dmY') . '.pdf';
            return $pdf->download($filename);

        } catch (\Throwable $e) {
            Log::error('PDF Download Error: ' . $e->getMessage());
            return redirect()->route('ktm.index')
                ->with('error', 'Gagal download PDF: ' . $e->getMessage());
        }
    }

    public function show($member_id)
    {
        $member = Member::where('member_id', $member_id)->first();

        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Data member tidak ditemukan');
        }

        return view('KartuAnggota.show', ['member' => $member]);
    }

    public function edit()
    {
        $member = Member::where('email', Auth::user()->email)->first();

        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Data member tidak ditemukan');
        }

        return view('KartuAnggota.editProfil', ['member' => $member]);
    }

    public function update(Request $request)
    {
        $member = Member::where('email', Auth::user()->email)->first();

        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Data member tidak ditemukan');
        }

        // Validasi input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:members,email,' . $member->id],
            'nim' => ['required', 'string', 'max:20', 'unique:members,nim,' . $member->id],
            'prodi' => ['required', 'string', 'max:100'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
        ]);

        try {
            // Handle foto upload jika ada
            if ($request->hasFile('photo')) {
                // Hapus foto lama jika ada
                if ($member->photo && file_exists(public_path('storage/' . $member->photo))) {
                    unlink(public_path('storage/' . $member->photo));
                }

                // Upload foto baru
                $photoPath = $request->file('photo')->store('photos', 'public');
                $validated['photo'] = $photoPath;
            }

            // Update member
            $member->update($validated);

            return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('profile.edit')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function imageDataUri(string $path): ?string
    {
        if (!file_exists($path)) {
            return null;
        }

        $mimeType = mime_content_type($path) ?: 'image/' . pathinfo($path, PATHINFO_EXTENSION);

        return 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($path));
    }
}
