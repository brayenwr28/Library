# 🚀 Quick Start Guide - Sistem Peminjaman Online

## ⚡ 5 Menit Setup

### 1. Pastikan Database Connected
```bash
cd d:\Perpus_Digital
php artisan migrate:status
```
✅ Output: `2026_01_31_000000_create_peminjamans_table ... [Ran]`

Jika belum, jalankan:
```bash
php artisan migrate
```

### 2. Start Development Server
```bash
php artisan serve
```
Output: `Server running on [http://127.0.0.1:8000]`

### 3. Open Browser
```
http://localhost:8000
```

---

## 📝 Test Scenario (5 Menit)

### Skenario A: Register Baru → Login → Peminjaman

**Step 1: Register (2 menit)**
- Buka: http://localhost:8000/register
- Isi form:
  - Nama: John Doe
  - Email: john@example.com
  - Username: johndoe
  - Password: password123
- Klik: Register
- ✅ Lihat kartu anggota

**Step 2: Logout (30 detik)**
- Klik: 🚪 Logout di kartu anggota
- ✅ Kembali ke home

**Step 3: Login (1 menit)**
- Buka: http://localhost:8000/login
- Isi:
  - Username: johndoe
  - Password: password123
- Klik: 🔐 Login
- ✅ Redirect ke form peminjaman

**Step 4: Peminjaman (1.5 menit)**
- Form sudah terisi: "Halo, John Doe!"
- Isi:
  - Judul Buku: Laravel Guide
  - Pengarang: Taylor Otwell
  - Tgl Pinjam: 2026-01-31 (hari ini)
  - Tgl Kembali: 2026-02-02
  - Upload: (skip atau upload screenshot JPG)
- Klik: 📋 Ajukan Peminjaman
- ✅ Redirect ke riwayat

**Step 5: Riwayat (30 detik)**
- ✅ Lihat alert: "Silakan ambil buku di perpustakaan dengan nomor antrian: ANT-20260131-0001"
- ✅ Lihat tabel dengan data peminjaman
- ✅ Terlihat: Nomor Antrian, Status (Menunggu), Tgl Pinjam, Tgl Kembali

---

### Skenario B: Test Middleware Protection

**Test: Akses tanpa login**
```
1. Clear browser cache / open incognito
2. Akses: http://localhost:8000/peminjaman
3. ✅ Redirect ke /login
4. Akses: http://localhost:8000/peminjaman/riwayat
5. ✅ Redirect ke /login
```

---

### Skenario C: Multiple Peminjaman (Nomor Antrian)

**Test: Antrian increment per hari**
```
1. Sudah login sebagai John Doe
2. Buka: http://localhost:8000/peminjaman
3. Ajukan peminjaman kedua (buku berbeda)
4. ✅ Nomor antrian: ANT-20260131-0002 (increment)
5. Ajukan peminjaman ketiga
6. ✅ Nomor antrian: ANT-20260131-0003 (increment)
```

---

## 🗄️ Database Queries

### Check Peminjamans
```bash
php artisan tinker

# List semua peminjaman
>>> \App\Models\Peminjaman::all();

# Lihat peminjaman member ID 1
>>> \App\Models\Peminjaman::where('member_id', 1)->get();

# Lihat dengan relasi member
>>> \App\Models\Peminjaman::with('member')->latest()->limit(5)->get();

# Count total hari ini
>>> \App\Models\Peminjaman::whereDate('created_at', today())->count();

# Generate nomor antrian berikutnya
>>> \App\Models\Peminjaman::generateNomorAntrian();

# Lihat file upload
>>> \App\Models\Peminjaman::where('bukti_registrasi', '!=', null)->get();
```

---

## 📂 File Locations

| Fungsi | File | Path |
|--------|------|------|
| Login Form | login-member.blade.php | resources/views/auth/ |
| Peminjaman Form | form.blade.php | resources/views/peminjamanonline/ |
| Riwayat View | riwayat.blade.php | resources/views/peminjamanonline/ |
| Login Controller | LoginController.php | app/Http/Controllers/ |
| Peminjaman Controller | PeminjamanController.php | app/Http/Controllers/ |
| Auth Middleware | MemberAuth.php | app/Http/Middleware/ |
| Peminjaman Model | Peminjaman.php | app/Models/ |
| Migration | create_peminjamans_table.php | database/migrations/ |
| Routes | web.php | routes/ |
| Upload Storage | bukti-registrasi/ | storage/app/public/ |

---

## 🔍 Key Features Summary

| Feature | Status | Location |
|---------|--------|----------|
| Login/Logout | ✅ Complete | LoginController |
| Session Auth | ✅ Complete | MemberAuth middleware |
| Peminjaman Form | ✅ Complete | form.blade.php |
| File Upload | ✅ Complete | PeminjamanController@store |
| Nomor Antrian | ✅ Complete | Peminjaman::generateNomorAntrian() |
| Riwayat View | ✅ Complete | riwayat.blade.php |
| Alert Message | ✅ Complete | Riwayat view |
| Database | ✅ Migrated | peminjamans table |
| Route Protection | ✅ Complete | member.auth middleware |

---

## 🐛 Common Issues & Solutions

### Issue: "Call to undefined method"
**Solution:**
```bash
composer dump-autoload
php artisan route:cache --clear
php artisan config:cache --clear
```

### Issue: File upload not working
**Solution:**
```bash
# Check storage link
ls -la public/storage

# Create if missing
php artisan storage:link
```

### Issue: Login redirect loop
**Solution:**
```bash
# Check session driver in .env
SESSION_DRIVER=file

# Clear all sessions
rm storage/framework/sessions/*
```

### Issue: Uploaded file not accessible
**Solution:**
```
Access via: http://localhost:8000/storage/bukti-registrasi/[filename]
Make sure symlink exists: public/storage → storage/app/public
```

---

## 🎯 URLs Reference

| Page | URL | Login Required |
|------|-----|---|
| Home | http://localhost:8000/ | ❌ No |
| Login | http://localhost:8000/login | ❌ No (guest) |
| Register | http://localhost:8000/register | ❌ No (guest) |
| Peminjaman Form | http://localhost:8000/peminjaman | ✅ Yes |
| Riwayat | http://localhost:8000/peminjaman/riwayat | ✅ Yes |
| Logout | http://localhost:8000/logout | ✅ Yes (POST) |

---

## 📊 Database Status

```
✅ Migration: 2026_01_31_000000_create_peminjamans_table [MIGRATED]
✅ Table: peminjamans (ready for data)
✅ Fields: 11 columns including PK, FK, dates, file path
✅ Constraints: Foreign key to members.id, unique nomor_antrian
✅ Timestamps: created_at, updated_at (automatic)
```

---

## 🚀 Production Checklist

Before going live:

- [ ] Database backed up
- [ ] All migrations run: `php artisan migrate`
- [ ] Storage symlink created: `php artisan storage:link`
- [ ] APP_KEY set: `php artisan key:generate`
- [ ] Env file configured (DB, MAIL, etc)
- [ ] File permissions: `chmod -R 775 storage bootstrap/cache`
- [ ] Session driver configured (file/database/redis)
- [ ] HTTPS enabled
- [ ] CORS headers configured if needed

---

## 💡 Tips

1. **Local Development**: Use `php artisan serve` instead of Apache/Nginx
2. **Debug Mode**: Set `APP_DEBUG=true` in `.env` untuk see detailed errors
3. **Database**: Gunakan `php artisan tinker` untuk query testing
4. **Testing**: Buka browser DevTools (F12) untuk check Network & Console
5. **File Upload**: Test dengan screenshot atau sampel image di folder public/images/

---

## 📞 Need Help?

1. Read: `IMPLEMENTATION_SUMMARY.md` - Full technical documentation
2. Read: `TESTING_GUIDE.md` - Detailed testing scenarios
3. Check: `storage/logs/laravel.log` - Error logs
4. Run: `php artisan tinker` - Interactive debugging
5. Check: `.env` file - Configuration

---

**Status**: ✅ READY TO TEST
**Last Updated**: 2026-01-31
**System**: Perpustakaan Digital v1.0
