<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Member;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pengunjung;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    /**
     * Dashboard Laporan - Menampilkan menu 4 laporan utama
     */
    public function index(): View
    {
        return view('admin.reports.index');
    }

    /**
     * Laporan Peminjaman - Daftar semua peminjaman dengan filter
     */
    public function laporanPeminjaman(Request $request): View
    {
        $query = Peminjaman::with(['member', 'book']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        // Filter by member
        if ($request->filled('member_id')) {
            $query->where('member_id', $request->member_id);
        }

        $peminjamans = $query->orderByDesc('created_at')->paginate(20);
        $members = Member::orderBy('name')->get();

        $stats = [
            'total' => Peminjaman::count(),
            'menunggu_konfirmasi' => Peminjaman::where('status', 'menunggu_konfirmasi')->count(),
            'diambil' => Peminjaman::where('status', 'diambil')->count(),
            'dikembalikan' => Peminjaman::where('status', 'dikembalikan')->count(),
            'ditolak' => Peminjaman::where('status', 'ditolak')->count(),
        ];

        return view('admin.reports.laporan-peminjaman', compact(
            'peminjamans',
            'members',
            'stats'
        ));
    }

    /**
     * Export Laporan Peminjaman ke PDF
     */
    public function exportPeminjamanPdf(Request $request)
    {
        $query = Peminjaman::with(['member', 'book']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        if ($request->filled('member_id')) {
            $query->where('member_id', $request->member_id);
        }

        $peminjamans = $query->orderByDesc('created_at')->get();

        $pdf = PDF::loadView('admin.reports.pdf.laporan-peminjaman-pdf', [
            'peminjamans' => $peminjamans,
            'dari_tanggal' => $request->dari_tanggal,
            'sampai_tanggal' => $request->sampai_tanggal,
        ]);

        return $pdf->download('Laporan_Peminjaman_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Laporan Pengembalian - Daftar semua pengembalian dengan filter
     */
    public function laporanPengembalian(Request $request): View
    {
        $query = Pengembalian::with(['peminjaman.member', 'peminjaman.book', 'admin']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $pengembalians = $query->orderByDesc('created_at')->paginate(20);

        $stats = [
            'total' => Pengembalian::count(),
            'menunggu_konfirmasi' => Pengembalian::where('status', 'menunggu_konfirmasi')->count(),
            'diterima' => Pengembalian::where('status', 'diterima')->count(),
            'ditolak' => Pengembalian::where('status', 'ditolak')->count(),
            'total_denda' => Pengembalian::where('status', 'diterima')->sum('denda'),
        ];

        return view('admin.reports.laporan-pengembalian', compact(
            'pengembalians',
            'stats'
        ));
    }

    /**
     * Export Laporan Pengembalian ke PDF
     */
    public function exportPengembalianPdf(Request $request)
    {
        $query = Pengembalian::with(['peminjaman.member', 'peminjaman.book', 'admin']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $pengembalians = $query->orderByDesc('created_at')->get();
        $totalDenda = $pengembalians->sum('denda');

        $pdf = PDF::loadView('admin.reports.pdf.laporan-pengembalian-pdf', [
            'pengembalians' => $pengembalians,
            'totalDenda' => $totalDenda,
            'dari_tanggal' => $request->dari_tanggal,
            'sampai_tanggal' => $request->sampai_tanggal,
        ]);

        return $pdf->download('Laporan_Pengembalian_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Laporan Pengunjung - Daftar semua pengunjung
     */
    public function laporanPengunjung(Request $request): View
    {
        $query = Pengunjung::query();

        // Filter by tipe pengunjung
        if ($request->filled('tipe_pengunjung')) {
            $query->where('tipe_pengunjung', $request->tipe_pengunjung);
        }

        // Filter by date range
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $pengunjungs = $query->orderByDesc('created_at')->paginate(20);

        $stats = [
            'total' => Pengunjung::count(),
            'mahasiswa' => Pengunjung::where('tipe_pengunjung', 'mahasiswa')->count(),
            'dosen' => Pengunjung::where('tipe_pengunjung', 'dosen')->count(),
            'umum' => Pengunjung::where('tipe_pengunjung', 'umum')->count(),
            'hari_ini' => Pengunjung::whereDate('created_at', today())->count(),
        ];

        return view('admin.reports.laporan-pengunjung', compact(
            'pengunjungs',
            'stats'
        ));
    }

    /**
     * Export Laporan Pengunjung ke PDF
     */
    public function exportPengunjungPdf(Request $request)
    {
        $query = Pengunjung::query();

        if ($request->filled('tipe_pengunjung')) {
            $query->where('tipe_pengunjung', $request->tipe_pengunjung);
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $pengunjungs = $query->orderByDesc('created_at')->get();

        $stats = [
            'mahasiswa' => $pengunjungs->where('tipe_pengunjung', 'mahasiswa')->count(),
            'dosen' => $pengunjungs->where('tipe_pengunjung', 'dosen')->count(),
            'umum' => $pengunjungs->where('tipe_pengunjung', 'umum')->count(),
        ];

        $pdf = PDF::loadView('admin.reports.pdf.laporan-pengunjung-pdf', [
            'pengunjungs' => $pengunjungs,
            'stats' => $stats,
            'dari_tanggal' => $request->dari_tanggal,
            'sampai_tanggal' => $request->sampai_tanggal,
        ]);

        return $pdf->download('Laporan_Pengunjung_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Laporan Anggota - Daftar semua anggota dengan statistik
     */
    public function laporanAnggota(Request $request): View
    {
        $query = Member::withCount('peminjamans');

        // Filter by nama atau email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('no_identitas', 'like', "%$search%");
        }

        // Filter by tipe member
        if ($request->filled('tipe_member')) {
            $query->where('tipe_member', $request->tipe_member);
        }

        // Filter by registration date
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $members = $query->orderBy('name')->paginate(20);

        $stats = [
            'total' => Member::count(),
            'aktif' => Member::where('status', 'aktif')->count(),
            'nonaktif' => Member::where('status', 'nonaktif')->count(),
            'total_peminjaman' => Peminjaman::count(),
        ];

        return view('admin.reports.laporan-anggota', compact(
            'members',
            'stats'
        ));
    }

    /**
     * Export Laporan Anggota ke PDF
     */
    public function exportAnggotaPdf(Request $request)
    {
        $query = Member::withCount('peminjamans');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('no_identitas', 'like', "%$search%");
        }

        if ($request->filled('tipe_member')) {
            $query->where('tipe_member', $request->tipe_member);
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $members = $query->orderBy('name')->get();

        $stats = [
            'total' => Member::count(),
            'aktif' => Member::where('status', 'aktif')->count(),
            'nonaktif' => Member::where('status', 'nonaktif')->count(),
        ];

        $pdf = PDF::loadView('admin.reports.pdf.laporan-anggota-pdf', [
            'members' => $members,
            'stats' => $stats,
            'dari_tanggal' => $request->dari_tanggal,
            'sampai_tanggal' => $request->sampai_tanggal,
        ]);

        return $pdf->download('Laporan_Anggota_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
