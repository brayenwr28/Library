<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nim',
        'nidn',
        'tipe_pengunjung',
    ];

    protected $dates = ['created_at', 'updated_at'];
}
