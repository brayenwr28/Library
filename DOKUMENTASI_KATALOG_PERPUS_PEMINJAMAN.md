# 📚 IMPLEMENTASI PEMINJAMAN KATALOG & PERPUS - DOKUMENTASI

**Tanggal Implementasi:** 23 April 2026  
**Status:** ✅ SELESAI

---

## 📋 RINGKASAN PERUBAHAN

### Tujuan
Membedakan alur peminjaman antara **Katalog Digital** dan **Perpustakaan Fisik** agar:
- Buku dari Katalog → mengarah ke form katalog (`formKatalog.blade.php`)
- Buku dari Perpus → mengarah ke form perpus (`formPerpus.blade.php`)

---

## ✅ PERUBAHAN YANG DILAKUKAN

### 1️⃣ **Controller: Tambah 2 Method Baru**

**File:** `app/Http/Controllers/PeminjamanController.php`

#### Method 1: `katalogForm()` (Line 71-108)
```php
public function katalogForm(Request $request): View|RedirectResponse
{
    // Hanya query dari tabel books (katalog digital)
    $books = Book::whereNotNull('pdf_path')
        ->where('status', 'available')
        ->where('stock', '>', 0)
        ->orderBy('title')
        ->get();
    
    // Return view formKatalog.blade.php dengan $source = 'katalog'
}
```

**Fitur:**
- ✅ Menampilkan hanya buku dari tabel `books`
- ✅ Cek stok dan validasi
- ✅ Pass parameter `source = 'katalog'` ke view

#### Method 2: `perpusForm()` (Line 110-146)
```php
public function perpusForm(Request $request): View|RedirectResponse
{
    // Hanya query dari tabel perpusses (perpustakaan fisik)
    $books = Perpuss::where('status', 'available')
        ->where('stock', '>', 0)
        ->whereNotNull('pdf_path')
        ->orderBy('title')
        ->get();
    
    // Return view formPerpus.blade.php dengan $source = 'perpus'
}
```

**Fitur:**
- ✅ Menampilkan hanya buku dari tabel `perpusses`
- ✅ Cek stok dan validasi
- ✅ Pass parameter `source = 'perpus'` ke view

---

### 2️⃣ **Routes: Tambah 2 Endpoint Baru**

**File:** `routes/web.php` (Line 52-60)

```php
Route::controller(PeminjamanController::class)->prefix('peminjaman')->group(function () {
    Route::get('/', 'index')->name('peminjaman.show');
    Route::post('/', 'store')->name('peminjaman.store');
    
    // ✨ BARU - Katalog
    Route::get('/katalog', 'katalogForm')->name('peminjaman.katalog');
    
    // ✨ BARU - Perpustakaan Fisik
    Route::get('/perpus', 'perpusForm')->name('peminjaman.perpus');
    
    Route::get('/riwayat', 'riwayat')->name('peminjaman.riwayat');
    Route::get('/riwayat/download-pdf', 'downloadRiwayatPdf')->name('peminjaman.riwayat.download');
    Route::get('/baca/{book}', 'read')->name('peminjaman.read');
    Route::get('/baca/{book}/stream', 'stream')->name('peminjaman.read.stream');
});
```

**Routes Baru:**
- 🔗 `GET /peminjaman/katalog` → `katalogForm()`
- 🔗 `GET /peminjaman/perpus` → `perpusForm()`

---

### 3️⃣ **Dashboard: Update Links**

#### File 1: `resources/views/dashboard/katalog.blade.php` (Line 103)
**Perubahan:**
```php
// SEBELUM
<a href="{{ route('peminjaman.show', ['book_id' => $book->id]) }}">

// SESUDAH
<a href="{{ route('peminjaman.katalog', ['book_id' => $book->id]) }}">
```

#### File 2: `resources/views/dashboard/perpus.blade.php` (Line 153)
**Perubahan:**
```php
// SEBELUM
<a href="{{ route('peminjaman.show', ['book_id' => $book->id]) }}">

// SESUDAH
<a href="{{ route('peminjaman.perpus', ['book_id' => $book->id]) }}">
```

---

## 🔄 ALUR PEMINJAMAN SETELAH PERUBAHAN

### **Alur 1: Peminjaman Katalog (Buku Digital)**

```
1. User di halaman Katalog
   ↓
2. Klik tombol "Pinjam Buku"
   ↓
3. Link: route('peminjaman.katalog', ['book_id' => X])
   ↓
4. GET /peminjaman/katalog?book_id=X
   ↓
5. Controller: PeminjamanController::katalogForm()
   ↓
6. Query buku hanya dari table BOOKS
   ↓
7. Return view('peminjaman.formKatalog', ['source' => 'katalog'])
   ↓
8. Form menampilkan buku dari katalog
   ↓
9. User isi tanggal pinjam & kembali
   ↓
10. Submit → POST /peminjaman → store()
   ↓
11. Data disimpan ke table peminjamans (book_id dari books)
   ↓
12. Redirect ke riwayat dengan nomor antrian
```

### **Alur 2: Peminjaman Perpustakaan Fisik**

```
1. User di halaman Perpus
   ↓
2. Klik tombol "Pinjam Buku"
   ↓
3. Link: route('peminjaman.perpus', ['book_id' => Y])
   ↓
4. GET /peminjaman/perpus?book_id=Y
   ↓
5. Controller: PeminjamanController::perpusForm()
   ↓
6. Query buku hanya dari table PERPUSSES
   ↓
7. Return view('peminjaman.formPerpus', ['source' => 'perpus'])
   ↓
8. Form menampilkan buku dari perpus
   ↓
9. User isi tanggal pinjam & kembali
   ↓
10. Submit → POST /peminjaman → store()
   ↓
11. Di store(): Cek buku di Books, jika tidak ada check Perpusses
   ↓
12. Jika dari Perpusses → Auto-copy ke Books (jika belum ada ISBN-nya)
   ↓
13. Data disimpan ke table peminjamans (book_id dari books)
   ↓
14. Redirect ke riwayat dengan nomor antrian
```

---

## 📌 PERBEDAAN FORM KATALOG VS PERPUS

| Aspek | Katalog (formKatalog.blade.php) | Perpus (formPerpus.blade.php) |
|-------|-----|-----|
| **Source Data** | Table `books` | Table `perpusses` |
| **Route GET** | `/peminjaman/katalog` | `/peminjaman/perpus` |
| **Form Field** | Book fields (title, author, etc.) | Perpuss fields |
| **Tipe Konten** | Digital (PDF) | Fisik (Koleksi Perpustakaan) |
| **Variable** | `$source = 'katalog'` | `$source = 'perpus'` |

**Catatan:** Kedua form saat ini terlihat identik di attachment, tapi parameter `$source` bisa digunakan untuk styling atau logika berbeda di masa depan.

---

## 🎯 CARA MENGGUNAKAN

### **Untuk User (Member):**
1. Buka halaman **Katalog** atau **Perpus** di dashboard
2. Pilih buku yang ingin dipinjam
3. Klik tombol **"Pinjam Buku"**
4. Sistem akan mengarahkan ke form yang sesuai:
   - Katalog → `formKatalog.blade.php`
   - Perpus → `formPerpus.blade.php`
5. Isi tanggal pinjam dan kembali
6. Submit form
7. Tunggu konfirmasi dari admin

---

## 🛠️ TROUBLESHOOTING

### **Error: Route not found**
```
❌ Error: Call to undefined route 'peminjaman.katalog'
```
**Solusi:**
```bash
php artisan cache:clear
php artisan route:cache
```

### **Buku tidak muncul di form**
**Check:**
- Buku memiliki `status = 'available'`?
- Buku memiliki `stock > 0`?
- Buku memiliki `pdf_path` (tidak NULL)?

**Query untuk verify:**
```php
// Untuk Katalog
Book::whereNotNull('pdf_path')->where('status', 'available')->where('stock', '>', 0)->get();

// Untuk Perpus
Perpuss::where('status', 'available')->where('stock', '>', 0)->whereNotNull('pdf_path')->get();
```

---

## ✨ FITUR BARU

1. ✅ **Pemisahan Form Katalog & Perpus**
   - User bisa membedakan source buku saat meminjam

2. ✅ **Route Terpisah**
   - `/peminjaman/katalog` - Khusus buku digital
   - `/peminjaman/perpus` - Khusus koleksi fisik

3. ✅ **Parameter Tracking**
   - View menerima `$source` untuk future customization

4. ✅ **Smart Auto-Migration** (existing feature)
   - Buku dari Perpus otomatis dicopy ke Books jika belum ada ISBN-nya

---

## 📝 TESTING CHECKLIST

- [ ] Buka katalog → klik "Pinjam Buku" → masuk ke formKatalog.blade.php ✓
- [ ] Buka perpus → klik "Pinjam Buku" → masuk ke formPerpus.blade.php ✓
- [ ] Isi form katalog dengan data valid → submit berhasil ✓
- [ ] Isi form perpus dengan data valid → submit berhasil ✓
- [ ] Nomor antrian generated dengan benar ✓
- [ ] Riwayat peminjaman menampilkan kedua type (katalog & perpus) ✓
- [ ] Clear cache command berjalan tanpa error ✓

---

## 📋 RINGKASAN FILES YANG DIUBAH

| File | Perubahan | Line |
|------|-----------|------|
| `app/Http/Controllers/PeminjamanController.php` | Tambah method `katalogForm()` & `perpusForm()` | 71-146 |
| `routes/web.php` | Tambah 2 route baru | 55-56 |
| `resources/views/dashboard/katalog.blade.php` | Update link ke `peminjaman.katalog` | 103 |
| `resources/views/dashboard/perpus.blade.php` | Update link ke `peminjaman.perpus` | 153 |

---

## 🔐 SECURITY & VALIDATION

- ✅ Hanya member yang login bisa akses form
- ✅ Validasi stok sebelum form ditampilkan
- ✅ Validasi member di method `resolveMember()`
- ✅ Duplicate loan prevention di `store()`
- ✅ Tanggal validation (tidak boleh backdate, kembali > pinjam)

---

**Last Updated:** 23 April 2026, 15:30 WIB  
**Status:** ✅ Siap Digunakan
