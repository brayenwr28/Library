<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'nim',
        'prodi',
        'member_id',
        'tgl_daftar',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tgl_daftar' => 'date',
    ];
}
