<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengunjung;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    /**
     * Menampilkan form input pengunjung
     */
    public function show()
    {
        return view('pengunjung.form');
    }

    /**
     * Menyimpan data pengunjung baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'nullable|string|max:50',
        ]);

        // Tentukan tipe pengunjung berdasarkan jumlah digit
        $tipe = 'umum';
        if (!empty($validated['nim'])) {
            $digits = strlen($validated['nim']);
            if ($digits == 12) {
                $tipe = 'mahasiswa';
            } elseif ($digits == 10) {
                $tipe = 'dosen';
            } else {
                $tipe = 'umum';
            }
        }

        $validated['tipe_pengunjung'] = $tipe;
        // Set nidn kosong karena sekarang menggunakan field nim untuk keduanya
        $validated['nidn'] = null;

        Pengunjung::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih telah mengunjungi perpustakaan kami!'
        ]);
    }

    /**
     * Redirect laporan pengunjung ke admin report untuk konsolidasi
     * Laporan sekarang diakses dari Admin > Reports > Pengunjung
     */
    public function index()
    {
        return redirect()->route('admin.report.pengunjung')
            ->with('info', 'Laporan pengunjung telah dipindahkan ke halaman Reports');
    }

    /**
     * Menghapus data pengunjung
     */
    public function destroy(Pengunjung $pengunjung)
    {
        $pengunjung->delete();

        return redirect()->route('pengunjung.index')
            ->with('success', 'Data pengunjung berhasil dihapus');
    }
}

