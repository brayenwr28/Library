<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perpuss extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'category',
        'isbn',
        'status',
        'stock',
        'cover_path',
        'pdf_path',
        'summary',
        'publication_year',
    ];

    protected $appends = ['cover_url'];

    public function getCoverUrlAttribute(): ?string
    {
        if (!$this->cover_path) {
            return null;
        }

        return '/storage/' . ltrim($this->cover_path, '/');
    }
}