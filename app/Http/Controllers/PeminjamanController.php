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

        // Query dari tabel books (yang memiliki stok > 0)
        $digitalBooks = Book::whereNotNull('pdf_path')
            ->where('status', 'available')
            ->where('stock', '>', 0)
            ->orderBy('title')
            ->get();

        // Query dari tabel perpusses (yang memiliki stok > 0)
        $perpussBooks = Perpuss::where('status', 'available')
            ->where('stock', '>', 0)
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
            
            // Cek apakah buku masih memiliki stok
            if ($selectedBook && $selectedBook->stock <= 0) {
                return back()->withErrors(['book_id' => 'Buku yang dipilih sudah tidak tersedia. Stok habis.'])->withInput();
            }
        }

        return view('peminjaman.form', [
            'member' => $member,
            'books' => $books,
            'selectedBookId' => $selectedBookId,
            'selectedBook' => $selectedBook,
        ]);
    }

    /**
     * Tampilkan form peminjaman untuk katalog (buku digital)
     */
    public function katalogForm(Request $request): View|RedirectResponse
    {
        $member = $this->resolveMember();

        if (! $member instanceof Member) {
            return $member;
        }

        // Query hanya dari tabel books (katalog digital)
        $books = Book::whereNotNull('pdf_path')
            ->where('status', 'available')
            ->where('stock', '>', 0)
            ->orderBy('title')
            ->get();

        $selectedBookId = $request->query('book_id');
        $selectedBook = null;

        // Jika ada parameter book_id, cari buku dari tabel books saja
        if ($selectedBookId) {
            $selectedBook = Book::find((int) $selectedBookId);
            
            // Cek apakah buku masih memiliki stok
            if ($selectedBook && $selectedBook->stock <= 0) {
                return back()->withErrors(['book_id' => 'Buku yang dipilih sudah tidak tersedia. Stok habis.'])->withInput();
            }
        }

        return view('peminjaman.formKatalog', [
            'member' => $member,
            'books' => $books,
            'selectedBookId' => $selectedBookId,
            'selectedBook' => $selectedBook,
            'source' => 'katalog',
        ]);
    }

    /**
     * Tampilkan form peminjaman untuk perpustakaan fisik
     */
    public function perpusForm(Request $request): View|RedirectResponse
    {
        $member = $this->resolveMember();

        if (! $member instanceof Member) {
            return $member;
        }

        // Query hanya dari tabel perpusses (perpustakaan fisik)
        $books = Perpuss::where('status', 'available')
            ->where('stock', '>', 0)
            ->whereNotNull('pdf_path')
            ->orderBy('title')
            ->get();

        $selectedBookId = $request->query('book_id');
        $selectedBook = null;

        // Jika ada parameter book_id, cari buku dari tabel perpusses saja
        if ($selectedBookId) {
            $selectedBook = Perpuss::find((int) $selectedBookId);
            
            // Cek apakah buku masih memiliki stok
            if ($selectedBook && $selectedBook->stock <= 0) {
                return back()->withErrors(['book_id' => 'Buku yang dipilih sudah tidak tersedia. Stok habis.'])->withInput();
            }
        }

        return view('peminjaman.formPerpus', [
            'member' => $member,
            'books' => $books,
            'selectedBookId' => $selectedBookId,
            'selectedBook' => $selectedBook,
            'source' => 'perpus',
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

        // Safety check: Verifikasi stok buku masih tersedia sebelum membuat peminjaman
        if ($book->stock <= 0) {
            return back()->withErrors([
                'book_id' => 'Stok buku sudah habis. Buku tidak dapat dipinjam saat ini. Hubungi petugas perpustakaan untuk informasi lebih lanjut.',
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
            'status' => 'menunggu_konfirmasi',
        ]);

        return redirect()->route('peminjaman.riwayat')->with([
            'success' => 'Permintaan peminjaman berhasil! Nomor antrian: '.$nomor_antrian,
            'alert' => 'Silakan tunggu konfirmasi dari admin. Anda akan menerima notifikasi saat permintaan diterima.',
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

    public function downloadRiwayatPdf()
    {
        $member = $this->resolveMember();

        if (! $member instanceof Member) {
            return $member;
        }

        // Process expired loans
        $expiredLoans = Peminjaman::where('member_id', $member->id)
            ->where('status', '!=', 'dikembalikan')
            ->whereDate('tgl_kembali', '<=', now()->toDateString())
            ->get();

        foreach ($expiredLoans as $loan) {
            $book = Book::find($loan->book_id);
            if ($book) {
                $book->stock += 1;
                $book->save();
            }

            if ($book && $book->isbn) {
                $perpussBook = Perpuss::where('isbn', $book->isbn)->first();
                if ($perpussBook) {
                    $perpussBook->stock += 1;
                    $perpussBook->save();
                }
            }

            $loan->status = 'dikembalikan';
            $loan->save();
        }

        $peminjamans = Peminjaman::where('member_id', $member->id)
            ->orderByDesc('created_at')
            ->get();

        $pdf = \PDF::loadView('peminjaman.riwayat-pdf', [
            'member' => $member,
            'peminjamans' => $peminjamans,
            'generatedAt' => now()->translatedFormat('d F Y H:i'),
        ]);

        return $pdf->download('Riwayat_Peminjaman_'.$member->name.'_'.now()->format('Y-m-d').'.pdf');
    }

    /**
     * LIST - Peminjaman yang menunggu konfirmasi admin
     */
    public function indexMenungguKonfirmasi(): View
    {
        $peminjamans = Peminjaman::with(['member', 'book'])
            ->where('status', 'menunggu_konfirmasi')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.peminjaman.menunggu-konfirmasi', [
            'peminjamans' => $peminjamans,
        ]);
    }

    /**
     * DETAIL - Peminjaman untuk konfirmasi
     */
    public function showKonfirmasi(Peminjaman $peminjaman): View
    {
        $peminjaman->load(['member', 'book']);

        return view('admin.peminjaman.detail-konfirmasi', [
            'peminjaman' => $peminjaman,
        ]);
    }

    /**
     * ACTION - Konfirmasi peminjaman (Admin Approve)
     */
    public function konfirmasiPeminjaman(Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== 'menunggu_konfirmasi') {
            return back()->withErrors(['error' => 'Peminjaman sudah diproses sebelumnya.']);
        }

        try {
            // Update status menjadi DIAMBIL
            $peminjaman->update([
                'status' => 'diambil',
            ]);

            // Kurangi stok buku
            $book = $peminjaman->book;
            if ($book && $book->stock > 0) {
                $book->decrement('stock');
            }

            // Kurangi stok perpusses jika ada
            if ($book && $book->isbn) {
                $perpussBook = Perpuss::where('isbn', $book->isbn)->first();
                if ($perpussBook && $perpussBook->stock > 0) {
                    $perpussBook->decrement('stock');
                }
            }

            return redirect()
                ->route('admin.peminjaman.menunggu')
                ->with('success', 'Peminjaman diterima! Member dapat mengambil buku dengan nomor antrian: ' . $peminjaman->nomor_antrian);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * ACTION - Tolak peminjaman
     */
    public function tolakPeminjaman(Peminjaman $peminjaman, Request $request): RedirectResponse
    {
        $request->validate([
            'alasan' => 'required|string|min:5|max:255',
        ]);

        if ($peminjaman->status !== 'menunggu_konfirmasi') {
            return back()->withErrors(['error' => 'Peminjaman sudah diproses sebelumnya.']);
        }

        try {
            // Update status menjadi DITOLAK dengan catatan alasan
            $peminjaman->update([
                'status' => 'ditolak',
                'catatan' => 'Alasan Penolakan: ' . $request->alasan,
            ]);

            return redirect()
                ->route('admin.peminjaman.menunggu')
                ->with('warning', 'Peminjaman ditolak. Member akan menerima notifikasi penolakan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
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
