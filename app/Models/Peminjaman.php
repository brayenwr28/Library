<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'member_id',
        'book_id',
        'perpuss_id',
        'book_type',
        'judul_buku',
        'nomor_antrian',
        'tgl_pinjam',
        'tgl_kembali',
        'bukti_registrasi',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_kembali' => 'date',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function perpuss(): BelongsTo
    {
        return $this->belongsTo(Perpuss::class);
    }

    /**
     * Relationship: Satu peminjaman bisa memiliki satu pengembalian
     */
    public function pengembalian(): HasOne
    {
        return $this->hasOne(Pengembalian::class);
    }

    /**
     * Scope: Ambil peminjaman yang menunggu konfirmasi
     */
    public function scopeMenungguKonfirmasi($query)
    {
        return $query->where('status', 'menunggu_konfirmasi');
    }

    /**
     * Scope: Ambil peminjaman yang sedang diambil (aktif)
     */
    public function scopeDiambil($query)
    {
        return $query->where('status', 'diambil');
    }

    /**
     * Scope: Ambil peminjaman yang sudah dikembalikan
     */
    public function scopeDikembalikan($query)
    {
        return $query->where('status', 'dikembalikan');
    }

    /**
     * Scope: Ambil peminjaman yang ditolak
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
            'diambil' => 'Sedang Dipinjam',
            'dikembalikan' => 'Sudah Dikembalikan',
            'ditolak' => 'Ditolak',
            default => 'Tidak Dikenal',
        };
    }

    public static function generateNomorAntrian()
    {
        $date = now()->format('Ymd');
        $today = now()->toDateString();
        $count = self::whereDate('created_at', $today)->count() + 1;
        $nomor = sprintf('%04d', $count);
        return 'ANT-' . $date . '-' . $nomor;
    }
}

