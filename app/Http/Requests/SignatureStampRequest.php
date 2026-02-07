<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignatureStampRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stamp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'signature.image' => 'Tanda tangan harus berupa gambar.',
            'signature.mimes' => 'Format gambar tanda tangan harus JPEG, PNG, JPG, atau GIF.',
            'signature.max' => 'Ukuran gambar tanda tangan tidak boleh lebih dari 2MB.',
            'stamp.image' => 'Stempel harus berupa gambar.',
            'stamp.mimes' => 'Format gambar stempel harus JPEG, PNG, JPG, atau GIF.',
            'stamp.max' => 'Ukuran gambar stempel tidak boleh lebih dari 2MB.',
        ];
    }
}
