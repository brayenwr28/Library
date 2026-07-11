<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeminjamanRequest;
use App\Models\Book;
use App\Models\Member;
use App\Models\Peminjaman;
use App\Models\Perpuss;
use App\Models\Pengembalian;
use Barryvdh\DomPDF\Facade\Pdf;
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
    private function calculateLoanDurationDays(Member $member): int
    {
        return $member->durasi_pinjam_hari ?? 7;
    }

    public function index(Request $request): View|RedirectResponse
    {
        $member = $this->resolveMember();

        if (! $member instanceof Member) {
            return $member;
        }

        // Query dari tabel books (katalog digital - yang memiliki stok > 0)
        $digitalBooks = Book::whereNotNull('pdf_path')
            ->where('status', 'available')
            ->where('stock', '>', 0)
            ->selectRaw("*, 'digital' as book_type")
            ->orderBy('title')
            ->get();

        // Query dari tabel perpusses (buku perpustakaan fisik - yang memiliki stok > 0)
        $perpussBooks = Perpuss::where('status', 'available')
            ->where('stock', '>', 0)
            ->selectRaw("*, 'perpustakaan' as book_type")
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
            if ($selectedBook) {
                $selectedBook->book_type = 'digital';
            } else {
                $selectedBook = Perpuss::find((int) $selectedBookId);
                if ($selectedBook) {
                    $selectedBook->book_type = 'perpustakaan';
                }
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
        // Catatan: Perpus adalah buku fisik, jadi tidak perlu pdf_path
        $books = Perpuss::where('status', 'available')
            ->where('stock', '>', 0)
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
        $bookType = $request->input('book_type', 'digital'); // Default to digital

        // Determine book source based on type
        if ($bookType === 'fisik') {
            $book = Perpuss::findOrFail($validated['book_id']);
        } else {
            $book = Book::findOrFail($validated['book_id']);
        }

        // Cek batasan maksimal 3 buku peminjaman aktif
        $activeBorrowCount = Peminjaman::where('member_id', $member->id)
            ->whereIn('status', ['menunggu_konfirmasi', 'diambil'])
            ->count();

        if ($activeBorrowCount >= 3) {
            return back()->withErrors([
                'book_id' => 'Batas maksimal peminjaman (3 buku) telah tercapai. Silakan kembalikan buku sebelumnya terlebih dahulu.',
            ])->withInput();
        }

        // Cek apakah ada denda yang belum lunas
        $hasUnpaidFine = \App\Models\Pengembalian::whereHas('peminjaman', function ($q) use ($member) {
            $q->where('member_id', $member->id);
        })->where('status_denda', 'belum_lunas')->exists();

        if ($hasUnpaidFine) {
            return back()->withErrors([
                'book_id' => 'Selesaikan pembayaran denda ke Pustaka Universitas Metamedia terlebih dahulu sebelum meminjam buku kembali.',
            ])->withInput();
        }

        try {
            $tgl_pinjam = Carbon::createFromFormat('Y-m-d', $validated['tgl_pinjam'])->startOfDay();
            $today = now()->startOfDay();

            if ($tgl_pinjam->lessThan($today)) {
                return back()->withErrors(['tgl_pinjam' => 'Tanggal pinjam harus hari ini atau lebih lambat.'])->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan dalam pemrosesan tanggal.'])->withInput();
        }

        $durasiPinjam = $this->calculateLoanDurationDays($member);
        $tgl_kembali = $tgl_pinjam->copy()->addDays($durasiPinjam);

        $bukti_path = null;
        if ($request->hasFile('bukti_registrasi')) {
            $bukti_path = $request->file('bukti_registrasi')->store('bukti-registrasi', 'public');
        }

        $duplicateLoan = Peminjaman::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->where('book_type', $bookType)
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

        $peminjamanData = [
            'member_id' => $member->id,
            'book_type' => $bookType,
            'judul_buku' => $book->title,
            'nomor_antrian' => $nomor_antrian,
            'tgl_pinjam' => $validated['tgl_pinjam'],
            'tgl_kembali' => $tgl_kembali->toDateString(),
            'bukti_registrasi' => $bukti_path,
            'status' => 'menunggu_konfirmasi',
        ];

        // Simpan ke kolom yang sesuai berdasarkan tipe buku
        if ($bookType === 'fisik') {
            $peminjamanData['perpuss_id'] = $book->id;
        } else {
            $peminjamanData['book_id'] = $book->id;
        }

        $peminjaman = Peminjaman::create($peminjamanData);

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

        $requiresBorrow = ! $book->pdf_path;

        $hasBorrowed = $requiresBorrow && Peminjaman::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->where('status', 'diambil')
            ->exists();

        if ($requiresBorrow && ! $hasBorrowed) {
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

        $requiresBorrow = ! $book->pdf_path;

        $hasBorrowed = $requiresBorrow && Peminjaman::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->where('status', 'diambil')
            ->exists();

        if ($requiresBorrow && ! $hasBorrowed) {
            abort(403, 'Akses ditolak. Silakan pinjam buku terlebih dahulu.');
        }

        if (! $book->pdf_path || ! Storage::disk('public')->exists($book->pdf_path)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        $downloadName = Str::slug($book->title).'.pdf';
        $stream = Storage::disk('public')->readStream($book->pdf_path);

        if ($stream === false) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        return response()->stream(
            function () use ($stream) {
                fpassthru($stream);

                if (is_resource($stream)) {
                    fclose($stream);
                }
            },
            200,
            [
                'Content-Type' => 'application/pdf',
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

        $peminjamans = Peminjaman::where('member_id', $member->id)
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView('peminjaman.riwayat-pdf', [
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

            // Kurangi stok buku berdasarkan tipe
            if ($peminjaman->book_type === 'fisik') {
                // Buku fisik dari Perpuss table
                $book = Perpuss::find($peminjaman->perpuss_id);
                if ($book && $book->stock > 0) {
                    $book->decrement('stock');
                }
            } else {
                // Buku digital dari Books table
                $book = Book::find($peminjaman->book_id);
                if ($book && $book->stock > 0) {
                    $book->decrement('stock');
                }
            }

            // Buat record pengembalian otomatis berstatus 'menunggu_konfirmasi'
            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tgl_kembali_aktual' => now()->toDateString(),
                'kondisi_buku' => 'baik',
                'denda' => 0,
                'status_denda' => 'lunas',
                'status' => 'menunggu_konfirmasi',
                'catatan' => 'Dibuat otomatis setelah peminjaman dikonfirmasi.',
            ]);

            return redirect()
                ->route('admin.pengembalian.menunggu')
                ->with('success', 'Peminjaman berhasil diterima! Transaksi otomatis diajukan ke Konfirmasi Pengembalian.');
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
                ->route('admin.pengembalian.index')
                ->with('warning', 'Peminjaman ditolak. Member akan menerima notifikasi penolakan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * ACTION - Update peminjaman dates
     */
    public function updateDates(Peminjaman $peminjaman, Request $request): RedirectResponse
    {
        $request->validate([
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        try {
            $peminjaman->update([
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_kembali' => $request->tgl_kembali,
            ]);

            return redirect()
                ->route('admin.peminjaman.menunggu')
                ->with('success', 'Tanggal peminjaman berhasil diperbarui.');
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
