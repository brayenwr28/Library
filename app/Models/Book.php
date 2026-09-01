<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publication_year',
        'category',
        'isbn',
        'stock',
        'cover_url',
        'pdf_path',
        'reference_url',
        'status',
        'summary',
    ];

    /**
     * Get full URL for book cover (supports HTTP URLs and uploaded local storage paths)
     */
    public function getCoverUrlAttribute($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        return asset('storage/' . $value);
    }
}
