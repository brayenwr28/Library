# 📚 DOKUMENTASI LENGKAP - SISTEM PERPUSTAKAAN DIGITAL

## 📖 CARA MEMBACA DOKUMENTASI

Dokumentasi ini sudah disusun untuk memudahkan pemahaman sistem:

### 1. **Mulai dari sini** ⭐ (File ini)
   - Overview sistem dan struktur dokumentasi

### 2. **QUICK_REFERENCE.md** (3 min read)
   - Cheat sheet: routes, methods, workflows
   - Untuk quick lookup saat development

### 3. **SYSTEM_FLOW.md** (15 min read)
   - Alur lengkap setiap flow (peminjaman, pengembalian, laporan)
   - Database structure & business rules
   - Authentication & authorization

### 4. **VISUAL_FLOWS.md** (10 min read)
   - Diagram ASCII untuk setiap flow
   - Database schema visualization
   - UI mockups

### 5. **CLEANUP_GUIDE.md** (5 min read)
   - Files to delete
   - Project maintenance tips

---

## 🎯 SISTEM OVERVIEW

### Tujuan Sistem
Mengelola peminjaman & pengembalian buku dengan workflow approval:
- ✅ Member submit peminjaman → Admin confirm
- ✅ Member return buku → Admin confirm + hitung denda
- ✅ Admin bisa view & export laporan
- ✅ Track denda otomatis (Rp.5000/minggu)

### 3 Main Modules

#### 1. **PEMINJAMAN SYSTEM**
```
Member Request → Admin Approval → Member Pickup
- Status progression: menunggu_konfirmasi → diambil → dikembalikan
- Stock management: reduced only when approved
- Rejection option: with reason storage
```

#### 2. **PENGEMBALIAN SYSTEM**
```
Member Return → Calculate Denda → Admin Approval → Process Complete
- Auto denda calculation: Rp.5000 × weeks_late
- Status progression: menunggu_konfirmasi → diterima → completed
- Rejection option: member still owes book
```

#### 3. **REPORTING SYSTEM**
```
4 Types of Reports (all with filter & PDF export):
- Laporan Peminjaman (loans with status)
- Laporan Pengembalian (returns with fines)
- Laporan Pengunjung (visitor statistics)
- Laporan Anggota (member data + activity)
```

---

## 📁 PROJECT STRUCTURE

```
d:\Pustaka\Library/
│
├── docs/                                    🎯 Documentation
│   ├── SYSTEM_FLOW.md                      ← Detailed flows
│   ├── VISUAL_FLOWS.md                     ← Diagrams
│   ├── QUICK_REFERENCE.md                  ← Cheat sheet
│   ├── CLEANUP_GUIDE.md                    ← Maintenance
│   ├── KTM_GUIDE.md                        ← ID Card system
│   └── TESTING_GUIDE.md                    ← Testing procedures
│
├── app/Http/Controllers/
│   ├── Admin/
│   │   ├── AdminReportController.php       🆕 All 4 reports
│   │   ├── AdminRegistrationController.php  ✏️ Dashboard enhanced
│   │   ├── BookController.php
│   │   ├── PerpussController.php
│   │   ├── PengunjungController.php
│   │   └── AdminRegistrationController.php
│   │
│   ├── PeminjamanController.php            ✏️ Loan system (+ konfirmasi)
│   ├── PengembalianController.php          ✏️ Return system
│   ├── DashboardController.php
│   ├── AuthController.php
│   └── KartuAnggotaController.php
│
├── app/Models/
│   ├── Peminjaman.php                      ✏️ Loan model
│   ├── Pengembalian.php                    ✏️ Return model
│   ├── Member.php
│   ├── Book.php
│   ├── Perpuss.php
│   ├── Pengunjung.php
│   ├── User.php
│   └── Admin.php
│
├── resources/views/
│   ├── admin/
│   │   ├── dashboard/
│   │   │   └── dashboard.blade.php        ✏️ Enhanced widgets
│   │   ├── peminjaman/
│   │   │   └── menunggu-konfirmasi.blade.php  🆕 Confirmation page
│   │   ├── pengembalian/
│   │   │   └── menunggu-konfirmasi.blade.php  🆕 Confirmation page
│   │   └── reports/                       🆕 All 4 reports
│   │       ├── laporan-peminjaman.blade.php
│   │       ├── laporan-pengembalian.blade.php
│   │       ├── laporan-pengunjung.blade.php
│   │       ├── laporan-anggota.blade.php
│   │       └── pdf/
│   │           ├── laporan-peminjaman-pdf.blade.php
│   │           ├── laporan-pengembalian-pdf.blade.php
│   │           ├── laporan-pengunjung-pdf.blade.php
│   │           └── laporan-anggota-pdf.blade.php
│   │
│   ├── layout/                             📍 Admin layout
│   │   ├── app.blade.php
│   │   ├── header.blade.php
│   │   ├── sidebar.blade.php
│   │   └── footer.blade.php
│   │
│   └── layouts/                            📍 Member layout
│       ├── app.blade.php
│       ├── app-with-navbar.blade.php
│       ├── navbar.blade.php
│       └── footer.blade.php
│
├── routes/
│   └── web.php                             ✏️ Updated routes (9 new groups)
│
├── database/
│   └── migrations/
│       ├── 2026_01_31_000000_create_peminjamans_table.php
│       ├── 2026_04_21_000000_create_pengembalians_table.php  🆕
│       └── ...other migrations
│
├── config/
│   ├── app.php
│   ├── database.php
│   ├── auth.php
│   └── ...
│
├── .env                                    🔐 Environment variables
├── .env.example                            📋 Environment template
├── composer.json                           📦 PHP dependencies
├── package.json                            📦 Node dependencies
├── vite.config.js                          ⚙️  Vite config
├── README.md                               📖 Project readme
└── ...other config files

Legend:
🆕 = New files created
✏️  = Modified files
📍 = Different layout for admin vs member
🎯 = Documentation
🔐 = Secure/config
📦 = Dependencies
⚙️  = Configuration
```

---

## 🚀 GETTING STARTED

### Step 1: Read Documentation (30 minutes)
1. **This file** - Overview (5 min)
2. **QUICK_REFERENCE.md** - Routes & methods (5 min)
3. **SYSTEM_FLOW.md** - Detailed flows (15 min)
4. **VISUAL_FLOWS.md** - Diagrams (5 min)

### Step 2: Review Code (1 hour)
Study these files in order:
1. `app/Models/Peminjaman.php` - Loan model
2. `app/Models/Pengembalian.php` - Return model
3. `app/Http/Controllers/PeminjamanController.php` - Loan logic
4. `app/Http/Controllers/Admin/AdminReportController.php` - Reports

### Step 3: Cleanup (15 minutes)
Follow CLEANUP_GUIDE.md:
- Delete 6 garbage files
- Verify no broken references
- Commit cleanup

### Step 4: Test (2 hours)
Use TESTING_GUIDE.md to test:
- Peminjaman flow (create → approve/reject)
- Pengembalian flow (create → accept/reject)
- Laporan flow (view → filter → export PDF)
- Dashboard widgets update correctly

---

## 📊 KEY FEATURES

### ✅ Implemented Features

1. **Konfirmasi Peminjaman**
   - Member submit → Status: menunggu_konfirmasi
   - Admin approve → Status: diambil, Stock: -1
   - Admin reject → Status: ditolak, Stock: unchanged
   - Routes: GET `/admin/peminjaman/menunggu`
   - View: `admin/peminjaman/menunggu-konfirmasi.blade.php`

2. **Konfirmasi Pengembalian**
   - Auto denda calculation: Rp.5000/minggu
   - Admin accept → Status: diterima, Stock: +1
   - Admin reject → Status: ditolak, Stock: unchanged
   - Routes: GET `/admin/pengembalian/menunggu`
   - View: `admin/pengembalian/menunggu-konfirmasi.blade.php`

3. **Dashboard Widgets**
   - Peminjaman Menunggu: N items (with link)
   - Pengembalian Menunggu: N items (with link)
   - Total Denda Hari Ini: Rp.X (calculated)

4. **Laporan System** (4 types)
   - **Laporan Peminjaman** - All loans with status filter
   - **Laporan Pengembalian** - All returns with denda tracking
   - **Laporan Pengunjung** - Visitor statistics
   - **Laporan Anggota** - Member data with activity
   - Each with: Filter, Pagination, Export PDF

---

## 🔗 ROUTE STRUCTURE

### Member Routes
```
/peminjaman                          Form & create loan
/peminjaman/riwayat                  History & statistics
/peminjaman/riwayat/download-pdf     Download history as PDF
/peminjaman/baca/{book}              Read digital book
/pengunjung/form                     Register visitor
```

### Admin Routes - Confirmation
```
/admin/peminjaman/menunggu           List pending loans
/admin/peminjaman/{id}/konfirmasi    Approve loan (PUT)
/admin/peminjaman/{id}/tolak         Reject loan (PUT)
/admin/pengembalian/menunggu         List pending returns
/admin/pengembalian/{id}/terima      Accept return (PUT)
/admin/pengembalian/{id}/tolak       Reject return (PUT)
```

### Admin Routes - Reports
```
/admin/reports/peminjaman            View loan report
/admin/reports/peminjaman/export-pdf Download PDF
/admin/reports/pengembalian          View return report
/admin/reports/pengembalian/export-pdf Download PDF
/admin/reports/pengunjung            View visitor report
/admin/reports/pengunjung/export-pdf Download PDF
/admin/reports/anggota               View member report
/admin/reports/anggota/export-pdf    Download PDF
```

---

## 💡 IMPORTANT CONCEPTS

### Status Progression

**Peminjaman (Loans):**
```
menunggu_konfirmasi → diambil → dikembalikan
                   → ditolak
```

**Pengembalian (Returns):**
```
menunggu_konfirmasi → diterima
                   → ditolak
```

### Stock Management

- **Peminjaman create:** Stock unchanged
- **Peminjaman approve:** Stock -1
- **Peminjaman reject:** Stock unchanged
- **Pengembalian accept:** Stock +1
- **Pengembalian reject:** Stock unchanged

### Denda Calculation

```
IF tgl_kembali_aktual > tgl_kembali_target:
  hari_terlambat = tgl_kembali_aktual - tgl_kembali_target
  minggu_terlambat = ceil(hari_terlambat / 7)
  denda = minggu_terlambat × Rp.5.000
ELSE:
  denda = 0
```

---

## 🧹 CLEANUP NEEDED

### Files to Delete (6 items)
```
diagnostic.php
get-logo-base64.php
logo_base64.txt
logo-base64-output.txt
php_modules.txt
resources/views/resourcesviewsKartuAnggotapdf.blade.php
```

See `CLEANUP_GUIDE.md` for detailed instructions.

---

## ✨ NEXT STEPS

1. ✅ **Read all documentation** (you are here!)
2. ⬜ **Review code files** (follow suggested order)
3. ⬜ **Clean up garbage files** (6 files to delete)
4. ⬜ **Run tests** (verify all flows)
5. ⬜ **Deploy to production** (after testing)

---

## 📞 SUPPORT

### Documentation
- **SYSTEM_FLOW.md** - For detailed understanding
- **VISUAL_FLOWS.md** - For visual learners
- **QUICK_REFERENCE.md** - For quick lookups

### Code Comments
Most important methods have comments:
- Controller methods
- Model relationships
- Database migrations

### Error Handling
- Validation messages are user-friendly
- Error logs in `storage/logs/`
- Debug mode available with `APP_DEBUG=true`

---

## 📅 PROJECT INFO

**Last Updated:** April 22, 2026  
**Status:** ✅ All 5 Requirements Implemented  
**Version:** 1.0.0  

**Features Implemented:**
- ✅ Admin/Pustakawan dapat receive returns
- ✅ Denda tracking: Rp.5000/minggu
- ✅ Return langsung ke perpustakaan dengan admin confirmation
- ✅ Loan dengan admin confirmation
- ✅ 4 Jenis Laporan (Peminjaman, Pengembalian, Pengunjung, Anggota)
- ✅ Dashboard dengan widgets & alerts
- ✅ PDF export untuk semua laporan
- ✅ Comprehensive documentation

**Files Created:** 16+
**Files Modified:** 4
**Database Tables:** Updated 2, Created 1
**Routes Added:** 9 groups

---

**Enjoy clean, well-documented code! Happy development! 🚀**
