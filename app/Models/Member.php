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

    /**
     * Relationship: Member memiliki banyak peminjaman
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}
