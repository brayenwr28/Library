<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';

    protected $fillable = [
        'peminjaman_id',
        'tgl_kembali_aktual',
        'kondisi_buku',
        'denda',
        'status_denda',
        'admin_id',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tgl_kembali_aktual' => 'date',
        'denda' => 'decimal:2',
    ];

    /**
     * Relationship: Pengembalian milik satu Peminjaman
     */
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }

    /**
     * Relationship: Admin yang mengkonfirmasi pengembalian
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Hitung denda otomatis jika terlambat
     * Denda: Rp.5000 per minggu (7 hari)
     * 
     * Contoh:
     * - Terlambat 3 hari: Rp.0
     * - Terlambat 7 hari (1 minggu): Rp.5.000
     * - Terlambat 14 hari (2 minggu): Rp.10.000
     */
    public static function hitungDenda($tgl_kembali_target, $tgl_kembali_aktual): float
    {
        $target = \Carbon\Carbon::parse($tgl_kembali_target);
        $aktual = \Carbon\Carbon::parse($tgl_kembali_aktual);

        // Jika dikembalikan tepat waktu atau lebih cepat
        if ($aktual->lte($target)) {
            return 0;
        }

        // Hitung selisih hari
        $hari_terlambat = $aktual->diffInDays($target);

        // Hitung berapa minggu (dibulatkan ke atas)
        $minggu_terlambat = ceil($hari_terlambat / 7);

        // Denda = minggu × Rp.5.000
        $denda_per_minggu = 5000;
        return $minggu_terlambat * $denda_per_minggu;
    }

    /**
     * Scope: Ambil pengembalian yang menunggu konfirmasi
     */
    public function scopeMenungguKonfirmasi($query)
    {
        return $query->where('status', 'menunggu_konfirmasi');
    }

    /**
     * Scope: Ambil pengembalian yang sudah diterima
     */
    public function scopeDiterima($query)
    {
        return $query->where('status', 'diterima');
    }

    /**
     * Scope: Ambil pengembalian yang ditolak
     */
    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    /**
     * Method: Status label (untuk tampilan)
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => 'Tidak Dikenal',
        };
    }

    /**
     * Method: Kondisi label (untuk tampilan)
     */
    public function getKondisiLabelAttribute(): string
    {
        return match($this->kondisi_buku) {
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            default => 'Tidak Dikenal',
        };
    }
}
