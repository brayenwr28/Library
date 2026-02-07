<?php

namespace App\Http\Controllers\Peminjaman;

use App\Models\Peminjaman;
use App\Models\Member;
use App\Http\Requests\PeminjamanRequest;

class PeminjamanController
{
    public function index()
    {
        $member_id = session('member_id');
        $member = Member::findOrFail($member_id);
        
        return view('peminjamanonline.form', compact('member'));
    }

    public function store(PeminjamanRequest $request)
    {
        $validated = $request->validated();

        // Validasi tanggal dengan Carbon
        try {
            $tgl_pinjam = \Carbon\Carbon::createFromFormat('Y-m-d', $validated['tgl_pinjam'])->startOfDay();
            $tgl_kembali = \Carbon\Carbon::createFromFormat('Y-m-d', $validated['tgl_kembali'])->startOfDay();
            $today = now()->startOfDay();

            // Cek apakah tgl_pinjam >= hari ini
            if ($tgl_pinjam->lessThan($today)) {
                return back()->withErrors(['tgl_pinjam' => 'Tanggal pinjam harus hari ini atau lebih lambat.'])->withInput();
            }

            // Cek apakah tgl_kembali > tgl_pinjam
            if (!$tgl_kembali->greaterThan($tgl_pinjam)) {
                return back()->withErrors(['tgl_kembali' => 'Tanggal kembali harus lebih lambat dari tanggal pinjam.'])->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan dalam pemrosesan tanggal.'])->withInput();
        }

        $member_id = session('member_id');
        
        // Upload bukti registrasi jika ada
        $bukti_path = null;
        if ($request->hasFile('bukti_registrasi')) {
            $bukti_path = $request->file('bukti_registrasi')->store('bukti-registrasi', 'public');
        }

        // Generate nomor antrian
        $nomor_antrian = Peminjaman::generateNomorAntrian();

        // Simpan peminjaman
        $peminjaman = Peminjaman::create([
            'member_id' => $member_id,
            'judul_buku' => $validated['judul_buku'],
            'nomor_antrian' => $nomor_antrian,
            'tgl_pinjam' => $validated['tgl_pinjam'],
            'tgl_kembali' => $validated['tgl_kembali'],
            'bukti_registrasi' => $bukti_path,
            'status' => 'pending',
        ]);

        return redirect()->route('peminjaman.riwayat')->with([
            'success' => 'Peminjaman berhasil! Nomor antrian: ' . $nomor_antrian,
            'alert' => 'Silakan ambil buku di perpustakaan dengan nomor antrian: ' . $nomor_antrian,
        ]);
    }

    public function riwayat()
    {
        $member_id = session('member_id');
        $member = Member::findOrFail($member_id);
        $peminjamans = Peminjaman::where('member_id', $member_id)
                                 ->orderBy('created_at', 'desc')
                                 ->get();

        return view('peminjamanonline.riwayat', compact('member', 'peminjamans'));
    }
}
