<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeminjamanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'book_id' => 'required|exists:books,id',
            'tgl_pinjam' => 'required|date_format:Y-m-d',
            'tgl_kembali' => 'required|date_format:Y-m-d|after:tgl_pinjam',
            'bukti_registrasi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'book_id.required' => 'Judul buku harus dipilih.',
            'book_id.exists' => 'Buku yang dipilih tidak ditemukan.',
            'tgl_pinjam.required' => 'Tanggal pinjam harus diisi.',
            'tgl_pinjam.date_format' => 'Format tanggal pinjam tidak valid (Y-m-d).',
            'tgl_kembali.required' => 'Tanggal kembali harus diisi.',
            'tgl_kembali.date_format' => 'Format tanggal kembali tidak valid (Y-m-d).',
            'tgl_kembali.after' => 'Tanggal kembali harus lebih lambat dari tanggal pinjam.',
            'bukti_registrasi.image' => 'Bukti registrasi harus berupa gambar.',
            'bukti_registrasi.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau GIF.',
            'bukti_registrasi.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ];
    }
}
