# Panduan Fitur KTM (Kartu Tanda Member)

## Deskripsi
Fitur KTM memungkinkan member untuk melihat dan mengunduh kartu identitas digital mereka dalam format PDF.

## File yang Dibuat

### 1. Controller: `app/Http/Controllers/KartuAnggotaController.php`
Controller yang menangani:
- `index()` - Menampilkan KTM member yang sedang login
- `downloadPDF()` - Download KTM dalam format PDF
- `show($member_id)` - Menampilkan KTM publik berdasarkan member_id

### 2. Views:
- `resources/views/KartuAnggota/index.blade.php` - View utama KTM dengan desain kartu
- `resources/views/KartuAnggota/show.blade.php` - View publik KTM
- `resources/views/KartuAnggota/pdf.blade.php` - Template PDF untuk download

### 3. Routes: `routes/web.php`
Routes yang ditambahkan:
```
/ktm                    - Menampilkan KTM member (auth required)
/ktm/download           - Download PDF KTM (auth required)
/ktm/{member_id}        - Menampilkan KTM publik
```

## Cara Menggunakan

### Untuk Member:
1. Login ke aplikasi
2. Akses `/ktm` untuk melihat KTM Anda
3. Klik tombol "Download PDF" untuk mengunduh kartu dalam format PDF
4. Print kartu dengan ukuran kertas A4

### Untuk Admin/Developer:
1. Member dapat melihat KTM publik orang lain melalui `/ktm/{member_id}`

## Data yang Ditampilkan di KTM:
- Nama
- NIM
- No. Member
- Program Studi
- Email
- Tanggal Daftar
- Logo Universitas
- Tempat Foto
- QR Code placeholder
- Tempat Tanda Tangan

## Fitur:
✅ Desain kartu modern dengan gradient
✅ Download PDF dengan layout rapi
✅ Responsive di berbagai ukuran layar
✅ Proteksi auth untuk fitur download
✅ Informasi penting di bawah kartu

## Customization:
Jika ingin mengedit desain:
1. Edit `resources/views/KartuAnggota/index.blade.php` untuk web view
2. Edit `resources/views/KartuAnggota/pdf.blade.php` untuk template PDF
3. Ubah warna gradient di CSS (saat ini: #667eea ke #764ba2)

## Dependencies:
Pastikan sudah install `barryvdh/laravel-dompdf` untuk PDF generation:
```bash
composer require barryvdh/laravel-dompdf
```

## Next Step (Optional):
1. Tambahkan upload foto member
2. Integrasikan QR Code encoder untuk nomor member
3. Tambahkan tanggungan digital
4. Buat fitur print langsung tanpa download
