# 📚 Sistem Peminjaman Online - Panduan Testing

## ✅ Status Implementasi

Semua fitur telah berhasil diimplementasikan:

### 1. **System Login** ✅
- Route: `GET /login` - Tampilkan form login
- Route: `POST /login` - Proses login dengan session-based auth
- Route: `POST /logout` - Logout dan hapus session
- File: `app/Http/Controllers/LoginController.php`
- View: `resources/views/auth/login-member.blade.php`

### 2. **Member Authentication Middleware** ✅
- Nama: `member.auth`
- File: `app/Http/Middleware/MemberAuth.php`
- Fungsi: Melindungi route peminjaman, redirect ke login jika belum auth
- Registered di: `app/Http/Kernel.php`

### 3. **Database Peminjaman** ✅
- Migration: `database/migrations/2026_01_31_000000_create_peminjamans_table.php`
- Status: ✅ SUDAH DIJALANKAN
- Tabel: `peminjamans` dengan fields:
  - `member_id` (FK ke members.id)
  - `judul_buku` (string, required)
  - `pengarang` (string, nullable)
  - `nomor_antrian` (unique, format: ANT-YYYYMMDD-XXXX)
  - `tgl_pinjam` (date, required)
  - `tgl_kembali` (date, nullable)
  - `bukti_registrasi` (string, nullable - path file upload)
  - `status` (enum: pending, diambil, dikembalikan)
  - `catatan` (text, nullable)

### 4. **Peminjaman Model** ✅
- File: `app/Models/Peminjaman.php`
- Relation: `belongsTo(Member::class)`
- Method: `generateNomorAntrian()` - Auto-generate nomor antrian format ANT-YYYYMMDD-XXXX

### 5. **Peminjaman Controller** ✅
- File: `app/Http/Controllers/PeminjamanController.php`
- Method 1: `index()` - Tampilkan form peminjaman
- Method 2: `store()` - Proses pengajuan dengan:
  - ✅ Validasi file upload (image max 2MB)
  - ✅ Upload bukti_registrasi ke `storage/bukti-registrasi/`
  - ✅ Generate nomor_antrian otomatis
  - ✅ Buat record di database
  - ✅ Redirect ke riwayat dengan alert
- Method 3: `riwayat()` - Tampilkan history peminjaman

### 6. **Views** ✅
- Form: `resources/views/peminjamanonline/form.blade.php`
  - Input: judul_buku (required), pengarang (optional)
  - Input: tgl_pinjam, tgl_kembali (date picker)
  - Input: bukti_registrasi (file upload, image only, max 2MB)
  - Tampil: Member info dari session
  - Buttons: Ajukan Peminjaman, Lihat Riwayat, Logout

- Riwayat: `resources/views/peminjamanonline/riwayat.blade.php`
  - Tabel dengan columns: No., Nama Buku, Pengarang, Tgl Pinjam, Tgl Kembali, Nomor Antrian, Status
  - Alert message: "Silakan ambil buku di perpustakaan dengan nomor antrian: [nomor]"
  - Status badge: Menunggu (yellow), Diambil (blue), Dikembalikan (green)
  - Empty state jika belum ada peminjaman
  - Responsive: Desktop table + Mobile card view

### 7. **Routes** ✅
```
GET  /login                    → LoginController@create (guest)
POST /login                    → LoginController@store (guest, name: login.store)
POST /logout                   → LoginController@logout (name: logout)
GET  /peminjaman               → PeminjamanController@index (member.auth, name: peminjaman.index)
POST /peminjaman               → PeminjamanController@store (member.auth, name: peminjaman.store)
GET  /peminjaman/riwayat       → PeminjamanController@riwayat (member.auth, name: peminjaman.riwayat)
```

---

## 🧪 Panduan Testing

### Flow 1: Register → Login → Peminjaman

```
1. REGISTER (atau gunakan member yang sudah ada)
   - Buka: http://localhost:8000/register
   - Isi form registrasi
   - Lihat kartu anggota
   - Catat: username dan password

2. LOGOUT
   - Klik tombol "🚪 Logout" di halaman kartu anggota
   - Redirect ke home

3. LOGIN
   - Buka: http://localhost:8000/login
   - Input: username (contoh: test123)
   - Input: password (yang digunakan saat register)
   - Klik "🔐 Login"
   - ✅ Redirect ke /peminjaman (form peminjaman)

4. PEMINJAMAN - UPLOAD BUKTI
   - Form sudah terisi nama member: "Halo, [nama_member]!"
   - Input: "Judul Buku" (misal: "Laravel Guide")
   - Input: "Pengarang" (misal: "Taylor Otwell")
   - Input: "Tanggal Pinjam" (pilih tanggal hari ini atau nanti)
   - Input: "Tanggal Kembali" (pilih tanggal setelah tanggal pinjam)
   - Upload: "Bukti Screenshot Registrasi" (upload SS/foto, format: JPEG/PNG/JPG/GIF, max 2MB)
   - Klik: "📋 Ajukan Peminjaman"

5. RIWAYAT & ALERT
   - ✅ Redirect ke /peminjaman/riwayat
   - ✅ Alert green: "Silakan ambil buku di perpustakaan dengan nomor antrian: ANT-20260131-0001"
   - ✅ Tampil tabel riwayat dengan:
     - Nama Buku: "Laravel Guide"
     - Pengarang: "Taylor Otwell"
     - Tanggal Pinjam: 31/01/2026 (format dd/mm/yyyy)
     - Tanggal Kembali: 02/02/2026
     - Nomor Antrian: "ANT-20260131-0001"
     - Status: "⏳ Menunggu"

6. PEMINJAMAN KEDUA (Nomor Antrian Increment)
   - Klik: "➕ Ajukan Peminjaman Baru"
   - Isi form dengan data berbeda
   - Upload bukti (atau skip jika optional)
   - Klik: "📋 Ajukan Peminjaman"
   - ✅ Nomor antrian akan bertambah: "ANT-20260131-0002"

7. LOGOUT
   - Klik: "🚪 Logout" (di riwayat atau form)
   - ✅ Redirect ke home dengan success message

8. AKSES TANPA LOGIN
   - Coba akses: http://localhost:8000/peminjaman
   - ✅ Redirect ke /login dengan error message
   - Coba akses: http://localhost:8000/peminjaman/riwayat
   - ✅ Redirect ke /login dengan error message
```

---

## 🔍 Database Queries (Testing)

Buka `php artisan tinker` dan jalankan:

```php
// 1. Lihat semua peminjaman
\App\Models\Peminjaman::all();

// 2. Lihat peminjaman member tertentu
\App\Models\Peminjaman::where('member_id', 1)->get();

// 3. Lihat nomor antrian hari ini
\App\Models\Peminjaman::whereDate('created_at', today())->get();

// 4. Generate nomor antrian baru
\App\Models\Peminjaman::generateNomorAntrian();

// 5. Lihat member dengan peminjaman
\App\Models\Member::with('peminjamans')->find(1);
```

---

## 📁 File Storage

Bukti registrasi yang diupload tersimpan di:
```
storage/app/public/bukti-registrasi/
```

Accessible via:
```
http://localhost:8000/storage/bukti-registrasi/[filename]
```

---

## 🔐 Session Data

Saat login, session berisi:
```php
session('member_id')  // ID member (int)
session('member')     // Object Member dengan semua field
```

---

## ✨ Features Checklist

- [x] Login dengan session-based auth
- [x] Logout dan destroy session
- [x] Member auth middleware
- [x] Form peminjaman dengan validasi
- [x] Upload bukti_registrasi (image validation, max 2MB)
- [x] Auto-generate nomor antrian (ANT-YYYYMMDD-XXXX)
- [x] Increment counter per hari
- [x] Database record creation
- [x] Riwayat peminjaman display
- [x] Status tracking (pending/diambil/dikembalikan)
- [x] Alert message setelah submit
- [x] Mobile responsive UI
- [x] Tailwind CSS styling
- [x] Error handling & validation messages
- [x] Responsive table & card view

---

## 🚀 Deployment Checklist

Sebelum production, pastikan:

- [ ] Database sudah migrate: `php artisan migrate`
- [ ] Storage link sudah buat: `php artisan storage:link`
- [ ] APP_KEY sudah set di `.env`: `php artisan key:generate`
- [ ] File permission untuk `storage/` writable
- [ ] File permission untuk `bootstrap/cache/` writable
- [ ] Session driver dikonfigurasi (default: file atau database)

---

Generated: 2026-01-31
System: Perpustakaan Digital - Peminjaman Online
