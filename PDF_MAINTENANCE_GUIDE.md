# 📋 PDF Download - Troubleshooting & Maintenance Guide

## ✅ System Requirements

### Wajib Ada:
1. **PHP GD Extension** - untuk processing gambar
   ```bash
   php -m | findstr gd
   # Output: gd ✅
   ```

2. **File-file yang diperlukan:**
   - `public/logo/logo-univ.png`
   - `public/images/stempel.jpg`
   - `public/images/ttddigital.jpg`

3. **Folder writable:**
   - `storage/` - untuk temporary files
   - `public/storage` - untuk member signatures & stamps

## 🔧 Health Check

Untuk cek kesehatan sistem PDF, jalankan:

```bash
php artisan pdf:health-check
```

Output akan menampilkan:
- Status GD Extension
- Lokasi folder yang diperlukan
- Keberadaan image files
- PHP settings yang relevan
- Laravel configuration

## ⚠️ Common Issues & Solutions

### Issue 1: GD Extension Not Active
**Error:** `The PHP GD extension is required, but is not installed`

**Solusi:**
1. Edit `C:\xampp\php\php.ini`
2. Cari baris `;extension=gd`
3. Hapus semicolon: `extension=gd`
4. Restart Apache

```powershell
# PowerShell (run as admin)
Stop-Process -Name "httpd" -Force
Start-Sleep -Seconds 2
Start-Process "C:\xampp\apache\bin\httpd.exe"
```

### Issue 2: Image File Not Found
**Error:** `File not found at path...`

**Solusi:**
- Pastikan file ada di `public/logo/` dan `public/images/`
- Check permissions (harus readable)
- Run: `php artisan pdf:health-check`

### Issue 3: Storage Not Writable
**Error:** `Storage tidak dapat ditulis`

**Solusi:**
```bash
# Set permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Windows XAMPP
icacls "D:\Perpus_Digital\storage" /grant:r Everyone:F
```

### Issue 4: Member Data Incomplete
**Error:** `Data anggota tidak lengkap`

**Solusi:**
- Member harus punya `member_id` dan `name`
- Jalankan: `php artisan tinker`
  ```php
  $member = App\Models\Member::find(26);
  $member->update(['member_id' => 'PUS202600001']);
  ```

### Issue 5: PDF File Cannot be Created
**Error:** `Cannot output pdf`

**Solusi:**
1. Check `storage/logs/laravel.log` untuk error details
2. Increase `memory_limit` di php.ini (min 512M)
3. Check disk space tersedia
4. Restart Apache

## 📊 Monitoring & Logging

Semua PDF operations dicatat di `storage/logs/laravel.log`

### Success Log:
```
[2026-02-05 10:30:15] local.INFO: PDF download success {"member_id":"26","member_name":"John Doe","filename":"kartu-pustaka-PUS202600001-20260205103015.pdf"}
```

### Error Log:
```
[2026-02-05 10:30:15] local.ERROR: PDF Download Error {"member_id":"26","error":"...","file":"...","line":...}
```

Untuk check real-time logs:
```bash
tail -f storage/logs/laravel.log
```

## 🚀 Preventive Maintenance

### Daily
- Cek error logs: `tail storage/logs/laravel.log`
- Monitor disk space

### Weekly
- Run health check: `php artisan pdf:health-check`
- Clear old cache: `php artisan cache:clear`
- Clear old logs (optional): `php artisan optimize:clear`

### Monthly
- Backup image files (logo, stempel, ttd)
- Review Laravel log files
- Test PDF download feature dengan berbagai member
- Update PHP jika ada security patches

## 🔒 Security Notes

1. **Image Files** - pastikan permissions 644 (readable, not executable)
2. **PDF Downloads** - tidak perlu authentication (sudah safe)
3. **Logging** - sensitive data tidak dicatat di logs
4. **File Size** - max image size adalah 5MB per file

## 📝 Related Files

- Controller: `app/Http/Controllers/Auth/RegisterController.php`
- Health Check Command: `app/Console/Commands/HealthCheckPdf.php`
- View Template: `resources/views/auth/member-card-pdf.blade.php`
- Configuration: `config/dompdf.php`

## ✉️ Support

Jika error masih terjadi:
1. Run: `php artisan pdf:health-check`
2. Check: `storage/logs/laravel.log`
3. Contact: Admin dengan log output
