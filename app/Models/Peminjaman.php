<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'member_id',
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

    public function member()
    {
        return $this->belongsTo(Member::class);
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
