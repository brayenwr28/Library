<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeminjamanRequest;
use App\Models\Book;
use App\Models\Member;
use App\Models\Peminjaman;
use App\Models\Perpuss;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $member = $this->resolveMember();

        if (! $member instanceof Member) {
            return $member;
        }

        // Query dari tabel books
        $digitalBooks = Book::whereNotNull('pdf_path')
            ->where('status', 'available')
            ->orderBy('title')
            ->get();

        // Query dari tabel perpusses (dengan pdf_path)
        $perpussBooks = Perpuss::where('status', 'available')
            ->whereNotNull('pdf_path')
            ->orderBy('title')
            ->get();

        // Gabungkan hasil dari kedua tabel
        $books = collect();
        $books = $books->concat($digitalBooks)->concat($perpussBooks)->sortBy('title');

        $selectedBookId = $request->query('book_id');
        $selectedBook = null;

        // Jika ada parameter book_id, cari buku dari kedua tabel
        if ($selectedBookId) {
            $selectedBook = Book::find((int) $selectedBookId);
            if (!$selectedBook) {
                $selectedBook = Perpuss::find((int) $selectedBookId);
            }
        }

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

        if (! $member instanceof Member) {
            return $member;
        }

        $validated = $request->validated();

        // Cari buku dari tabel books atau perpusses
        $book = Book::find($validated['book_id']);
        $perpussBook = null;
        
        // Jika buku dari perpusses, check atau copy ke books table dulu
        if (!$book) {
            $perpussBook = Perpuss::findOrFail($validated['book_id']);
            
            // Check apakah buku dengan ISBN yang sama sudah ada di books
            if ($perpussBook->isbn) {
                $book = Book::where('isbn', $perpussBook->isbn)->first();
            }
            
            // Jika belum ada, buat buku baru di books table
            if (!$book) {
                $book = Book::create([
                    'title' => $perpussBook->title,
                    'author' => $perpussBook->author,
                    'publisher' => $perpussBook->publisher,
                    'publication_year' => $perpussBook->publication_year,
                    'category' => $perpussBook->category,
                    'isbn' => $perpussBook->isbn,
                    'status' => $perpussBook->status,
                    'stock' => $perpussBook->stock,
                    'cover_url' => $perpussBook->cover_path,
                    'pdf_path' => $perpussBook->pdf_path,
                    'summary' => $perpussBook->summary,
                ]);
            }
        }

        try {
            $tgl_pinjam = Carbon::createFromFormat('Y-m-d', $validated['tgl_pinjam'])->startOfDay();
            $tgl_kembali = Carbon::createFromFormat('Y-m-d', $validated['tgl_kembali'])->startOfDay();
            $today = now()->startOfDay();

            if ($tgl_pinjam->lessThan($today)) {
                return back()->withErrors(['tgl_pinjam' => 'Tanggal pinjam harus hari ini atau lebih lambat.'])->withInput();
            }

            if (! $tgl_kembali->greaterThan($tgl_pinjam)) {
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

        $peminjaman = Peminjaman::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'judul_buku' => $book->title,
            'nomor_antrian' => $nomor_antrian,
            'tgl_pinjam' => $validated['tgl_pinjam'],
            'tgl_kembali' => $validated['tgl_kembali'],
            'bukti_registrasi' => $bukti_path,
            'status' => 'diambil',
        ]);

        // Kurangi stok buku jika tersedia
        if ($book->stock > 0) {
            $book->stock -= 1;
            $book->save();
        }

        // Kurangi stok perpusses juga jika buku asalnya dari perpusses
        if ($perpussBook && $perpussBook->stock > 0) {
            $perpussBook->stock -= 1;
            $perpussBook->save();
        }

        return redirect()->route('peminjaman.riwayat')->with([
            'success' => 'Peminjaman berhasil! Nomor antrian: '.$nomor_antrian,
            'alert' => 'Silakan ambil buku di perpustakaan dengan nomor antrian: '.$nomor_antrian,
        ]);
    }

    public function riwayat(): View|RedirectResponse
    {
        $member = $this->resolveMember();

        if (! $member instanceof Member) {
            return $member;
        }

        // Cari peminjaman yang sudah lewat waktu dan belum dikembalikan
        $expiredLoans = Peminjaman::where('member_id', $member->id)
            ->where('status', '!=', 'dikembalikan')
            ->whereDate('tgl_kembali', '<=', now()->toDateString())
            ->get();

        // Process setiap peminjaman yang sudah expired
        foreach ($expiredLoans as $loan) {
            // Kembalikan stok buku di tabel books
            $book = Book::find($loan->book_id);
            if ($book) {
                $book->stock += 1;
                $book->save();
            }

            // Kembalikan stok di tabel perpusses jika ada buku dengan ISBN yang sama
            if ($book && $book->isbn) {
                $perpussBook = Perpuss::where('isbn', $book->isbn)->first();
                if ($perpussBook) {
                    $perpussBook->stock += 1;
                    $perpussBook->save();
                }
            }

            // Update status menjadi dikembalikan
            $loan->status = 'dikembalikan';
            $loan->save();
        }

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

        if (! $member instanceof Member) {
            return $member;
        }

        $hasBorrowed = Peminjaman::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->where('status', 'diambil')
            ->exists();

        if (! $hasBorrowed) {
            return redirect()
                ->route('katalog')
                ->withErrors(['access' => 'Silakan ajukan peminjaman untuk membaca buku ini.']);
        }

        if (! $book->pdf_path || ! Storage::disk('public')->exists($book->pdf_path)) {
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

        if (! $member instanceof Member) {
            return $member;
        }

        $hasBorrowed = Peminjaman::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->where('status', 'diambil')
            ->exists();

        if (! $hasBorrowed) {
            abort(403, 'Akses ditolak. Silakan pinjam buku terlebih dahulu.');
        }

        if (! $book->pdf_path || ! Storage::disk('public')->exists($book->pdf_path)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        $downloadName = Str::slug($book->title).'.pdf';

        return Storage::disk('public')->response(
            $book->pdf_path,
            $downloadName,
            [
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Content-Disposition' => 'inline; filename="'.$downloadName.'"',
            ]
        );
    }

    private function resolveMember(): Member|RedirectResponse
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->withErrors([
                'auth' => 'Silakan masuk terlebih dahulu untuk mengakses peminjaman.',
            ]);
        }

        $member = Member::where('email', $user->email)->first();

        if (! $member) {
            return redirect()->route('dashboard')->withErrors([
                'member' => 'Data anggota tidak ditemukan. Hubungi petugas untuk registrasi.',
            ]);
        }

        return $member;
    }
}
