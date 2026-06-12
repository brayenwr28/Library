<?php

namespace App\Http\Requests;

use App\Models\Book;
use App\Models\Perpuss;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PeminjamanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'book_type' => 'required|in:digital,fisik',
            'book_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $bookType = $this->input('book_type', 'digital');
                    
                    // Validate based on book type
                    if ($bookType === 'fisik') {
                        $book = Perpuss::find($value);
                        if (!$book) {
                            $fail('Buku fisik yang dipilih tidak ditemukan.');
                            return;
                        }
                    } else {
                        $book = Book::find($value);
                        if (!$book) {
                            $fail('Buku digital yang dipilih tidak ditemukan.');
                            return;
                        }
                    }
                    
                    // Check stok buku
                    if ($book->stock <= 0) {
                        $fail('Stok buku sudah habis. Buku tidak dapat dipinjam saat ini.');
                    }
                }
            ],
            'tgl_pinjam' => 'required|date_format:Y-m-d',
            'bukti_registrasi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'book_id.required' => 'Judul buku harus dipilih.',
            'tgl_pinjam.required' => 'Tanggal pinjam harus diisi.',
            'tgl_pinjam.date_format' => 'Format tanggal pinjam tidak valid (Y-m-d).',
            'bukti_registrasi.image' => 'Bukti registrasi harus berupa gambar.',
            'bukti_registrasi.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau GIF.',
            'bukti_registrasi.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ];
    }
}
