<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeminjamanRequest;
use App\Models\Book;
use App\Models\Member;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $member = $this->resolveMember();

        if (!$member instanceof Member) {
            return $member;
        }

        $books = Book::whereNotNull('pdf_path')
            ->where('status', 'available')
            ->orderBy('title')
            ->get();

        $selectedBookId = $request->query('book_id');

        if ($selectedBookId && !$books->contains('id', (int) $selectedBookId)) {
            $selectedBookId = null;
        }

        $selectedBook = $selectedBookId
            ? $books->firstWhere('id', (int) $selectedBookId)
            : null;

        return view('peminjaman.form', [
            'member' => $member,
            'books' => $books,
            'selectedBookId' => $selectedBookId,
            'selectedBook' => $selectedBook,
        ]);
    }

    public function store(PeminjamanRequest $request): RedirectResponse
    {
        $member = $this->resolveMember();

        if (!$member instanceof Member) {
            return $member;
        }

        $validated = $request->validated();

        $book = Book::findOrFail($validated['book_id']);

        try {
            $tgl_pinjam = Carbon::createFromFormat('Y-m-d', $validated['tgl_pinjam'])->startOfDay();
            $tgl_kembali = Carbon::createFromFormat('Y-m-d', $validated['tgl_kembali'])->startOfDay();
            $today = now()->startOfDay();

            if ($tgl_pinjam->lessThan($today)) {
                return back()->withErrors(['tgl_pinjam' => 'Tanggal pinjam harus hari ini atau lebih lambat.'])->withInput();
            }

            if (!$tgl_kembali->greaterThan($tgl_pinjam)) {
                return back()->withErrors(['tgl_kembali' => 'Tanggal kembali harus lebih lambat dari tanggal pinjam.'])->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan dalam pemrosesan tanggal.'])->withInput();
        }

        $bukti_path = null;
        if ($request->hasFile('bukti_registrasi')) {
            $bukti_path = $request->file('bukti_registrasi')->store('bukti-registrasi', 'public');
        }

        $duplicateLoan = Peminjaman::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->where('status', 'diambil')
            ->exists();

        if ($duplicateLoan) {
            return back()->withErrors([
                'book_id' => 'Anda masih memiliki peminjaman aktif untuk buku ini. Selesaikan terlebih dahulu sebelum meminjam kembali.',
            ])->withInput();
        }

        $nomor_antrian = Peminjaman::generateNomorAntrian();

        Peminjaman::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'judul_buku' => $book->title,
            'nomor_antrian' => $nomor_antrian,
            'tgl_pinjam' => $validated['tgl_pinjam'],
            'tgl_kembali' => $validated['tgl_kembali'],
            'bukti_registrasi' => $bukti_path,
            'status' => 'diambil',
        ]);

        return redirect()->route('peminjaman.riwayat')->with([
            'success' => 'Peminjaman berhasil! Nomor antrian: ' . $nomor_antrian,
            'alert' => 'Silakan ambil buku di perpustakaan dengan nomor antrian: ' . $nomor_antrian,
        ]);
    }

    public function riwayat(): View|RedirectResponse
    {
        $member = $this->resolveMember();

        if (!$member instanceof Member) {
            return $member;
        }

        Peminjaman::where('member_id', $member->id)
            ->where('status', '!=', 'dikembalikan')
            ->whereDate('tgl_kembali', '<=', now()->toDateString())
            ->update(['status' => 'dikembalikan']);

        $peminjamans = Peminjaman::where('member_id', $member->id)
            ->orderByDesc('created_at')
            ->get();

        return view('peminjaman.riwayat', [
            'member' => $member,
            'peminjamans' => $peminjamans,
        ]);
    }

    public function read(Book $book): View|RedirectResponse
    {
        $member = $this->resolveMember();

        if (!$member instanceof Member) {
            return $member;
        }

        $hasBorrowed = Peminjaman::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->where('status', 'diambil')
            ->exists();

        if (!$hasBorrowed) {
            return redirect()
                ->route('katalog')
                ->withErrors(['access' => 'Silakan ajukan peminjaman untuk membaca buku ini.']);
        }

        if (!$book->pdf_path || !Storage::disk('public')->exists($book->pdf_path)) {
            return redirect()
                ->route('katalog')
                ->withErrors(['pdf' => 'File PDF buku tidak ditemukan.']);
        }

        $pdfUrl = route('peminjaman.read.stream', ['book' => $book->id]);

        return view('peminjaman.read', [
            'member' => $member,
            'book' => $book,
            'pdfUrl' => $pdfUrl,
        ]);
    }

    public function stream(Book $book)
    {
        $member = $this->resolveMember();

        if (!$member instanceof Member) {
            return $member;
        }

        $hasBorrowed = Peminjaman::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->where('status', 'diambil')
            ->exists();

        if (!$hasBorrowed) {
            abort(403, 'Akses ditolak. Silakan pinjam buku terlebih dahulu.');
        }

        if (!$book->pdf_path || !Storage::disk('public')->exists($book->pdf_path)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        $downloadName = Str::slug($book->title) . '.pdf';

        return Storage::disk('public')->response(
            $book->pdf_path,
            $downloadName,
            [
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Content-Disposition' => 'inline; filename="' . $downloadName . '"',
            ]
        );
    }

    private function resolveMember(): Member|RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'auth' => 'Silakan masuk terlebih dahulu untuk mengakses peminjaman.',
            ]);
        }

        $member = Member::where('email', $user->email)->first();

        if (!$member) {
            return redirect()->route('dashboard')->withErrors([
                'member' => 'Data anggota tidak ditemukan. Hubungi petugas untuk registrasi.',
            ]);
        }

        return $member;
    }
}
