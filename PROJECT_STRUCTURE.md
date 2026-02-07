# Struktur Project Perpus Digital - FINAL

## 📁 Struktur Folder yang Sudah Diorganisir

```
app/Http/Controllers/
├── Auth/
│   ├── LoginController.php        # Member login (session-based)
│   └── RegisterController.php     # Member registration & member card
├── Admin/
│   └── SignatureStampController.php  # Admin signature/stamp management
├── Peminjaman/
│   └── PeminjamanController.php   # Loan request handling
├── Perpustakaan/
│   └── PdfHelperController.php    # PDF utilities
└── Controller.php                  # Base controller

app/Http/Requests/
├── LoginRequest.php               # Login validation
├── RegisterRequest.php            # Registration validation
├── PeminjamanRequest.php          # Loan request validation
└── SignatureStampRequest.php      # Signature/stamp upload validation

resources/views/
├── auth/
│   ├── login-member.blade.php
│   ├── register.blade.php
│   └── member-card.blade.php
├── peminjamanonline/
│   ├── form.blade.php
│   └── riwayat.blade.php
├── admin/
│   └── signature-stamp-form.blade.php
├── layouts/
│   └── app.blade.php
├── welcome.blade.php
├── contact.blade.php
├── katalog.blade.php
├── sejarah.blade.php
└── tentang.blade.php
```

## 🔐 RBAC System (Role-Based Access Control)

### User Roles
- **admin** - Administrator sistem
- **pustakawan** - Librarian/Pemustaka
- **user** - Regular user

### Helper Methods (User Model)
```php
auth()->user()->isAdmin()              // Check if admin
auth()->user()->isPustakawan()         // Check if librarian
auth()->user()->isUser()               // Check if regular user
auth()->user()->isAdminOrPustakawan()  // Check if admin or librarian
auth()->user()->is_active              // Check if account active
```

### Middleware Protection
```php
Route::middleware(['auth', 'verified', 'role:admin'])->group(...)
Route::middleware(['auth', 'check.status'])->group(...)
Route::middleware(['member.auth'])->group(...)
```

### Gates (Authorization)
```php
@can('isAdmin')
@can('isPustakawan')
@can('isAdminOrPustakawan')
@can('isActive')
```

## 📝 Routes Mapping

### Authentication Routes
```
GET  /login                    → Auth/LoginController@create
POST /login                    → Auth/LoginController@store
POST /logout                   → Auth/LoginController@logout
GET  /register                 → Auth/RegisterController@create
POST /register                 → Auth/RegisterController@store
GET  /member/{id}/card         → Auth/RegisterController@card
```

### Peminjaman Routes (Member)
```
GET  /peminjaman               → Peminjaman/PeminjamanController@index
POST /peminjaman               → Peminjaman/PeminjamanController@store
GET  /peminjaman/riwayat       → Peminjaman/PeminjamanController@riwayat
```

### Admin Routes
```
GET  /admin/signature-stamp    → Admin/SignatureStampController@form
POST /admin/signature-stamp    → Admin/SignatureStampController@upload
```

## 📚 Models

### User Model
- role: enum (admin, pustakawan, user)
- is_active: boolean
- Helper methods untuk role checking

### Member Model
- username, name, email, password
- nim, prodi (student info)
- member_id, tgl_daftar
- signature_path, stamp_path
- Relationship: hasMany Peminjaman

### Peminjaman Model
- member_id (foreign key)
- judul_buku, nomor_antrian
- tgl_pinjam, tgl_kembali
- bukti_registrasi
- status (pending, approved, returned)
- Relationship: belongsTo Member

## 🔧 Migration

File: `database/migrations/2026_01_31_123840_add_role_to_users_table.php`

Menambahkan column:
- `role` - enum('admin', 'pustakawan', 'user')
- `is_active` - boolean (default: true)

## ✅ Validasi

### Request Classes (app/Http/Requests/)
- **LoginRequest**: username, password
- **RegisterRequest**: username, name, email, password (confirmed), nim, prodi
- **PeminjamanRequest**: judul_buku, tgl_pinjam, tgl_kembali, bukti_registrasi
- **SignatureStampRequest**: signature (image), stamp (image)

## 🚀 Langkah Selanjutnya (Optional)

1. **Services Layer** - Business logic layer
   - `app/Services/AuthService.php`
   - `app/Services/PeminjamanService.php`

2. **Traits** - Reusable functionality
   - `app/Traits/HasTimestamps.php`
   - `app/Traits/HasUuid.php`

3. **Enums** - Type-safe constants
   - `app/Enums/UserRole.php`
   - `app/Enums/PeminjamanStatus.php`

4. **Helpers** - Utility functions
   - `app/Helpers/PeminjamanHelper.php`
   - `app/Helpers/FileHelper.php`

5. **Constants** - Configuration values
   - `app/Constants/PeminjamanConstants.php`

## 📖 Testing Credentials

```
Admin User:
- Email: admin@perpus.local
- Password: admin
- Role: admin

Librarian User:
- Email: pustakawan@perpus.local
- Password: pustakawan
- Role: pustakawan

Regular User:
- Email: user@perpus.local
- Password: user
- Role: user

Inactive User:
- Email: nonaktif@perpus.local
- Password: nonaktif
- Role: user (but is_active = false)
```

## 📌 Penting

- Member menggunakan session-based authentication (tidak menggunakan User model)
- User menggunakan Laravel's built-in authentication dengan role-based access
- Pemisahan antara Member (perpustakaan) dan User (admin system)
- Semua file sudah terorganisir dengan baik dan siap untuk development
