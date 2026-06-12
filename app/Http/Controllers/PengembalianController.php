<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Perpuss;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PengembalianController extends Controller
{
    /**
     * Daftar peminjaman aktif yang bisa diproses menjadi pengembalian
     */
    public function index(): View
    {
        $peminjamans = Peminjaman::with(['member', 'book', 'perpuss'])
            ->where('status', 'diambil')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.pengembalian.index', [
            'peminjamans' => $peminjamans,
        ]);
    }

    /**
     * List pengembalian yang menunggu konfirmasi admin
     */
    public function indexMenunggu(): View
    {
        $pengembalians = Pengembalian::with(['peminjaman.member', 'peminjaman.book', 'admin'])
            ->where('status', 'menunggu_konfirmasi')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.pengembalian.menunggu-konfirmasi', [
            'pengembalians' => $pengembalians,
        ]);
    }

    /**
     * Detail pengembalian untuk konfirmasi
     */
    public function show(Pengembalian $pengembalian): View
    {
        $pengembalian->load(['peminjaman.member', 'peminjaman.book', 'admin']);

        return view('admin.pengembalian.detail', [
            'pengembalian' => $pengembalian,
        ]);
    }

    /**
     * Terima pengembalian buku
     */
    public function terima(Pengembalian $pengembalian): RedirectResponse
    {
        if ($pengembalian->status !== 'menunggu_konfirmasi') {
            return back()->withErrors(['error' => 'Pengembalian sudah diproses sebelumnya.']);
        }

        $admin = Auth::guard('admin')->user();

        if (! $admin) {
            return redirect()->route('admin.login')->withErrors([
                'auth' => 'Sesi admin tidak valid. Silakan login kembali.',
            ]);
        }

        try {
            // Update status pengembalian menjadi DITERIMA
            $pengembalian->update([
                'status' => 'diterima',
                'admin_id' => $admin->id,
            ]);

            // Update status peminjaman menjadi DIKEMBALIKAN
            $peminjaman = $pengembalian->peminjaman;
            $peminjaman->update([
                'status' => 'dikembalikan',
            ]);

            // Tambah stok buku kembali (baik itu dari books atau perpusses)
            $book = $peminjaman->book;
            if ($book) {
                $book->increment('stock');
            }

            // Jika buku dari perpusses, tambah stok di perpusses juga
            if ($book && $book->isbn) {
                $perpussBook = Perpuss::where('isbn', $book->isbn)->first();
                if ($perpussBook) {
                    $perpussBook->increment('stock');
                }
            }

            return redirect()
                ->route('admin.pengembalian.menunggu')
                ->with('success', 'Pengembalian berhasil diterima! Buku dikembalikan ke stok.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Tolak pengembalian buku
     */
    public function tolak(Pengembalian $pengembalian, Request $request): RedirectResponse
    {
        $request->validate([
            'alasan' => 'required|string|min:5|max:255',
        ]);

        if ($pengembalian->status !== 'menunggu_konfirmasi') {
            return back()->withErrors(['error' => 'Pengembalian sudah diproses sebelumnya.']);
        }

        $admin = Auth::guard('admin')->user();

        if (! $admin) {
            return redirect()->route('admin.login')->withErrors([
                'auth' => 'Sesi admin tidak valid. Silakan login kembali.',
            ]);
        }

        try {
            // Update status pengembalian menjadi DITOLAK dengan catatan alasan
            $pengembalian->update([
                'status' => 'ditolak',
                'catatan' => 'Alasan Penolakan: ' . $request->alasan,
                'admin_id' => $admin->id,
            ]);

            return redirect()
                ->route('admin.pengembalian.menunggu')
                ->with('warning', 'Pengembalian ditolak. Silakan hubungi member untuk penyelesaian lebih lanjut.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Form input pengembalian (untuk petugas di perpustakaan)
     */
    public function createForm(Peminjaman $peminjaman): View|RedirectResponse
    {
        // Cek apakah peminjaman status DIAMBIL (sedang dipinjam)
        if ($peminjaman->status !== 'diambil') {
            return back()->withErrors(['error' => 'Peminjaman ini tidak bisa dikembalikan. Status harus DIAMBIL.']);
        }

        // Cek apakah sudah ada pengembalian di pending
        $existingPengembalian = Pengembalian::where('peminjaman_id', $peminjaman->id)
            ->where('status', 'menunggu_konfirmasi')
            ->first();

        if ($existingPengembalian) {
            return back()->withErrors(['error' => 'Pengembalian untuk buku ini sudah dalam proses konfirmasi.']);
        }

        return view('admin.pengembalian.form', [
            'peminjaman' => $peminjaman->load('member', 'book', 'perpuss'),
        ]);
    }

    /**
     * Submit form pengembalian (Petugas input data pengembalian)
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tgl_kembali_aktual' => 'required|date|before_or_equal:today',
            'kondisi_buku' => 'required|in:baik,rusak_ringan,rusak_berat',
            'catatan' => 'nullable|string|max:255',
        ]);

        try {
            $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

            // Validasi status peminjaman
            if ($peminjaman->status !== 'diambil') {
                return back()->withErrors(['error' => 'Peminjaman ini tidak bisa dikembalikan.']);
            }

            // Hitung denda otomatis
            $denda = Pengembalian::hitungDenda(
                $peminjaman->tgl_kembali,
                $request->tgl_kembali_aktual
            );

            // Buat record pengembalian
            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tgl_kembali_aktual' => $request->tgl_kembali_aktual,
                'kondisi_buku' => $request->kondisi_buku,
                'denda' => $denda,
                'status' => 'menunggu_konfirmasi',
                'catatan' => $request->catatan,
            ]);

            return redirect()
                ->route('admin.pengembalian.index')
                ->with('success', 'Data pengembalian berhasil disimpan! Menunggu konfirmasi admin.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * History pengembalian (sudah diterima/ditolak)
     */
    public function history(): View
    {
        $pengembalians = Pengembalian::with(['peminjaman.member', 'peminjaman.book', 'admin'])
            ->where('status', '!=', 'menunggu_konfirmasi')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.pengembalian.history', [
            'pengembalians' => $pengembalians,
        ]);
    }
}
