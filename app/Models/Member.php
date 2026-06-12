<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'nim',
        'prodi',
        'jenis_anggota',
        'photo',
        'member_id',
        'tgl_daftar',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tgl_daftar' => 'date',
    ];

    public function getJenisAnggotaLabelAttribute(): string
    {
        return match ($this->jenis_anggota ?? 'mahasiswa') {
            'mahasiswa' => 'Mahasiswa',
            'dosen' => 'Dosen',
            default => 'Mahasiswa',
        };
    }

    public function getDurasiPinjamHariAttribute(): int
    {
        return match ($this->jenis_anggota ?? 'mahasiswa') {
            'dosen' => 80,
            default => 7,
        };
    }

    /**
     * Relationship: Member memiliki banyak peminjaman
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}
