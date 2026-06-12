# 🏗️ ALUR SISTEM PERPUSTAKAAN DIGITAL

## 📌 OVERVIEW SISTEM

Sistem Perpustakaan Digital memiliki 3 main flows:
1. **Flow Peminjaman** (Member request → Admin confirm → Member ambil)
2. **Flow Pengembalian** (Member return → Admin confirm + hitung denda)
3. **Flow Laporan** (Admin view & export berbagai laporan)

---

## 1️⃣ FLOW PEMINJAMAN BUKU

```
┌─────────────────────────────────────────────────────────────────┐
│ MEMBER SIDE                                                     │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ 1. Member buka "/peminjaman"                                    │
│    ↓                                                            │
│ 2. Lihat list buku dengan stok > 0                             │
│    ↓                                                            │
│ 3. Pilih buku, isi form (tgl pinjam, tgl kembali, bukti)       │
│    ↓                                                            │
│ 4. Submit form                                                  │
│    ↓ (POST /peminjaman)                                        │
│ 5. Sistem buat Peminjaman dengan status: "menunggu_konfirmasi" │
│    - Stok TIDAK dikurangi dulu                                 │
│    - Generate nomor antrian otomatis                           │
│    ↓                                                            │
│ 6. Member redirect ke /peminjaman/riwayat                      │
│    - Lihat status: "Menunggu Konfirmasi"                       │
│    - Bisa lihat riwayat peminjaman (download PDF)             │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘

                            ↓↓↓

┌─────────────────────────────────────────────────────────────────┐
│ ADMIN SIDE                                                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ 1. Admin login ke dashboard (/login/admin → /dashboard)        │
│    ↓                                                            │
│ 2. Lihat widget "Peminjaman Menunggu Konfirmasi" (N items)     │
│    ↓ Klik "Lihat Detail" button                               │
│ 3. Masuk ke /admin/peminjaman/menunggu                         │
│    - Lihat table semua peminjaman menunggu                     │
│    - No Antrian, Member, Buku, Tanggal, Status                │
│    ↓                                                            │
│ 4. Per row ada 2 buttons: "Terima" & "Tolak"                   │
│    ↓                                                            │
│ ┌─ OPSI A: TERIMA PEMINJAMAN ─────────────────────────────┐   │
│ │                                                          │   │
│ │ 5A. Klik button "Terima"                                │   │
│ │     ↓ (PUT /admin/peminjaman/{id}/konfirmasi)          │   │
│ │ 6A. Sistem:                                             │   │
│ │     - Update status: "diambil"                          │   │
│ │     - Kurangi stok buku (books & perpusses)            │   │
│ │     - Redirect ke /admin/peminjaman/menunggu            │   │
│ │     - Show success message                              │   │
│ │     ↓                                                    │   │
│ │ 7A. Member dapat notif (terima email/notif in-app)     │   │
│ │     → Bisa ambil buku di perpustakaan                   │   │
│ │                                                          │   │
│ └──────────────────────────────────────────────────────────┘   │
│                                                                 │
│ ┌─ OPSI B: TOLAK PEMINJAMAN ──────────────────────────────┐   │
│ │                                                          │   │
│ │ 5B. Klik button "Tolak"                                 │   │
│ │     ↓ Modal dialog appear                               │   │
│ │ 6B. Admin isi alasan penolakan (textarea)               │   │
│ │     ↓ (PUT /admin/peminjaman/{id}/tolak)               │   │
│ │ 7B. Sistem:                                             │   │
│ │     - Update status: "ditolak"                          │   │
│ │     - Simpan alasan di column "catatan"                │   │
│ │     - Stok tidak berubah (tetap utuh)                   │   │
│ │     - Redirect ke /admin/peminjaman/menunggu            │   │
│ │     - Show warning message                              │   │
│ │     ↓                                                    │   │
│ │ 8B. Member dapat notif penolakan + alasan               │   │
│ │     → Bisa coba pinjam buku lain                        │   │
│ │                                                          │   │
│ └──────────────────────────────────────────────────────────┘   │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

**Database Changes:**
- Table: `peminjamans`
  - Status: `menunggu_konfirmasi` → `diambil` (atau `ditolak`)
  - Stock NOT reduced on creation (reduced on approval only)

---

## 2️⃣ FLOW PENGEMBALIAN BUKU

```
┌─────────────────────────────────────────────────────────────────┐
│ PETUGAS / ADMIN INPUT                                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ 1. Member menyerahkan buku fisik ke perpustakaan               │
│    ↓                                                            │
│ 2. Petugas membuka menu "Transaksi Pengembalian"              │
│    ↓                                                            │
│ 3. Pilih "Input Pengembalian" lalu buka form buku aktif        │
│    - Daftar berasal dari peminjaman berstatus "diambil"        │
│    ↓                                                            │
│ 4. Input data pengembalian:                                     │
│    - Tanggal kembali aktual                                     │
│    - Kondisi buku: baik / rusak_ringan / rusak_berat           │
│    - Catatan petugas (opsional)                                 │
│    ↓                                                            │
│ 5. Sistem membuat Pengembalian dengan status: "menunggu_konfirmasi" │
│    - Hitung denda otomatis: Rp.5000/minggu jika terlambat      │
│    ↓                                                            │
│ 6. Petugas menyimpan data dan memberi bukti proses ke member    │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘

                            ↓↓↓

┌─────────────────────────────────────────────────────────────────┐
│ ADMIN SIDE (KONFIRMASI)                                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ 1. Admin login ke dashboard                                    │
│    ↓                                                            │
│ 2. Lihat widget "Pengembalian Menunggu Konfirmasi" (N items)   │
│    ↓ Klik "Lihat Detail" button                               │
│ 3. Masuk ke /admin/pengembalian/menunggu                       │
│    - Lihat table semua pengembalian menunggu                   │
│    - No Antrian, Member, Buku, Tgl Kembali Rencana/Aktual     │
│    - Kondisi, Denda, Status                                   │
│    ↓                                                            │
│ 4. Per row ada 2 buttons: "Terima" & "Tolak"                  │
│    ↓                                                            │
│ ┌─ OPSI A: TERIMA PENGEMBALIAN ───────────────────────────┐   │
│ │                                                          │   │
│ │ 5A. Klik button "Terima"                                │   │
│ │     ↓ (PUT /admin/pengembalian/{id}/terima)            │   │
│ │ 6A. Sistem:                                             │   │
│ │     - Update pengembalian status: "diterima"           │   │
│ │     - Update peminjaman status: "dikembalikan"         │   │
│ │     - Restore stok buku (books & perpusses) +1         │   │
│ │     - Catat admin yang menerima (admin_id)             │   │
│ │     - Redirect ke /admin/pengembalian/menunggu          │   │
│ │     - Show success message                              │   │
│ │     ↓                                                    │   │
│ │ 7A. Dashboard update widget "Total Denda Hari Ini"     │   │
│ │                                                          │   │
│ └──────────────────────────────────────────────────────────┘   │
│                                                                 │
│ ┌─ OPSI B: TOLAK PENGEMBALIAN ────────────────────────────┐   │
│ │                                                          │   │
│ │ 5B. Klik button "Tolak"                                 │   │
│ │     ↓ Modal dialog appear                               │   │
│ │ 6B. Admin isi alasan penolakan (textarea)               │   │
│ │     ↓ (PUT /admin/pengembalian/{id}/tolak)             │   │
│ │ 7B. Sistem:                                             │   │
│ │     - Update pengembalian status: "ditolak"            │   │
│ │     - Simpan alasan di column "catatan"                │   │
│ │     - Stok tidak restore (tetap berkurang)             │   │
│ │     - Catat admin yang tolak (admin_id)                │   │
│ │     - Redirect ke /admin/pengembalian/menunggu          │   │
│ │     - Show warning message                              │   │
│ │     ↓                                                    │   │
│ │ 8B. Member harus menyelesaikan masalah (hubungi admin) │   │
│ │                                                          │   │
│ └──────────────────────────────────────────────────────────┘   │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘

DENDA CALCULATION:
─────────────────────────────────────────────────────────────────
Tgl Rencana Kembali: 10 April 2026
Tgl Aktual Kembali:  27 April 2026
Terlambat: 17 hari

Minggu terlambat = ceil(17 / 7) = 3 minggu
Denda = 3 × Rp 5.000 = Rp 15.000
─────────────────────────────────────────────────────────────────
```

**Database Changes:**
- Table: `pengembalians` (created on return)
  - Status: `menunggu_konfirmasi` → `diterima` (or `ditolak`)
  - Denda: calculated automatically
  - Stock: restored on approval only

---

## 3️⃣ FLOW LAPORAN (Admin Reports)

```
┌─────────────────────────────────────────────────────────────────┐
│ ADMIN REPORT DASHBOARD                                          │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ Routes:                                                         │
│ - /admin/reports/peminjaman      (Laporan Peminjaman)         │
│ - /admin/reports/pengembalian    (Laporan Pengembalian)       │
│ - /admin/reports/pengunjung      (Laporan Pengunjung)         │
│ - /admin/reports/anggota         (Laporan Anggota)            │
│                                                                 │
│                                                                 │
│ SETIAP LAPORAN PUNYA:                                          │
│ ┌─────────────────────────────────────────────────────────┐  │
│ │ 1. STATISTICS WIDGETS (Top cards)                       │  │
│ │    - Total, Stats breakdown, Pending count             │  │
│ │                                                          │  │
│ │ 2. FILTER SECTION                                       │  │
│ │    - Search, Date range, Status filter, etc.           │  │
│ │    - Button "Filter" (GET request dengan query params) │  │
│ │                                                          │  │
│ │ 3. DATA TABLE (Paginated)                              │  │
│ │    - Responsive table dengan 20 items per page         │  │
│ │    - Pagination links                                  │  │
│ │                                                          │  │
│ │ 4. EXPORT PDF BUTTON                                   │  │
│ │    - Preserve filter params                            │  │
│ │    - Download PDF file                                 │  │
│ │                                                          │  │
│ └─────────────────────────────────────────────────────────┘  │
│                                                                 │
├─ LAPORAN PEMINJAMAN ─────────────────────────────────────────┤
│ GET /admin/reports/peminjaman                                 │
│                                                                 │
│ Filter: Status, Member, Date Range                            │
│ Stats: Total, Menunggu, Diambil, Dikembalikan, Ditolak        │
│ Columns: No.Antrian, Member, Judul, Tgl Pinjam-Kembali, Status│
│ Export: /admin/reports/peminjaman/export-pdf                  │
│                                                                 │
├─ LAPORAN PENGEMBALIAN ──────────────────────────────────────┤
│ GET /admin/reports/pengembalian                               │
│                                                                 │
│ Filter: Status, Date Range                                    │
│ Stats: Total, Menunggu, Diterima, Ditolak, Total Denda        │
│ Columns: No.Antrian, Member, Judul, Kondisi, Denda, Status    │
│ Export: /admin/reports/pengembalian/export-pdf                │
│                                                                 │
├─ LAPORAN PENGUNJUNG ─────────────────────────────────────────┤
│ GET /admin/reports/pengunjung                                 │
│                                                                 │
│ Filter: Tipe Pengunjung, Date Range                           │
│ Stats: Total, Mahasiswa, Dosen, Umum, Hari Ini               │
│ Columns: Nama, NIM/NIDN, Tipe, Tanggal Kunjung               │
│ Export: /admin/reports/pengunjung/export-pdf                  │
│                                                                 │
├─ LAPORAN ANGGOTA ────────────────────────────────────────────┤
│ GET /admin/reports/anggota                                    │
│                                                                 │
│ Filter: Search (nama/email/ID), Date Range                    │
│ Stats: Total, Aktif, Nonaktif, Total Peminjaman              │
│ Columns: Nama, Email, ID, Tipe, Jumlah Peminjaman, Tgl Daftar│
│ Export: /admin/reports/anggota/export-pdf                     │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## 📊 DATABASE STRUCTURE

```
PEMINJAMANS TABLE:
┌──────────────────────────────────────────────────────┐
│ id, member_id, book_id, judul_buku                   │
│ nomor_antrian (unique), tgl_pinjam, tgl_kembali      │
│ bukti_registrasi, status, catatan                    │
│ STATUSES: menunggu_konfirmasi → diambil → dikembalikan (or ditolak) │
└──────────────────────────────────────────────────────┘

PENGEMBALIANS TABLE:
┌──────────────────────────────────────────────────────┐
│ id, peminjaman_id (FK), tgl_kembali_aktual           │
│ kondisi_buku (baik/rusak_ringan/rusak_berat)         │
│ denda (decimal), admin_id, status, catatan           │
│ STATUSES: menunggu_konfirmasi → diterima (or ditolak) │
└──────────────────────────────────────────────────────┘

DENDA CALCULATION:
- Rp.5.000 per minggu (7 hari) keterlambatan
- Minimal: Rp.0 jika tepat waktu
```

---

## 🎯 KEY BUSINESS RULES

1. **Peminjaman:**
   - Status harus `menunggu_konfirmasi` saat dibuat
   - Stok dikurangi HANYA saat admin approve (status `diambil`)
   - Jika ditolak, stok tidak berubah

2. **Pengembalian:**
   - Denda otomatis dihitung berdasarkan keterlambatan
   - Stok dikembalikan HANYA saat admin terima (status `diterima`)
   - Jika ditolak, stok tetap berkurang (member masih utang)

3. **Laporan:**
   - Filter bisa dikombinasikan
   - Semua laporan bisa di-export sebagai PDF
   - Query params preserved saat export PDF

---

## 🔐 AUTHENTICATION & AUTHORIZATION

```
PUBLIC PAGES:
- /auth/login (member login)
- /login/admin (admin login)
- /auth/register (member register)

MEMBER PAGES (middleware: auth):
- /peminjaman (form peminjaman)
- /peminjaman/riwayat (history + download PDF)
- /ktm/* (Kartu Tanda Member)

ADMIN PAGES (middleware: auth:admin):
- /login/admin/dashboard (dashboard)
- /admin/peminjaman/menunggu (confirmation)
- /admin/pengembalian (input pengembalian)
- /admin/pengembalian/menunggu (confirmation)
- /admin/reports/* (semua laporan)
```

---

## 📁 FILES STRUCTURE

```
app/Http/Controllers/
├── Admin/
│   ├── AdminReportController.php (NEW - all 4 reports)
│   ├── AdminRegistrationController.php (updated dashboard)
│   ├── BookController.php
│   └── ...
├── PeminjamanController.php (updated store + add konfirmasi methods)
├── PengembalianController.php (updated routes redirect)
└── ...

resources/views/
├── admin/
│   ├── dashboard/dashboard.blade.php (updated - widgets)
│   ├── peminjaman/menunggu-konfirmasi.blade.php (NEW)
│   ├── pengembalian/index.blade.php (NEW - daftar peminjaman aktif)
│   ├── pengembalian/form.blade.php (NEW - input pengembalian)
│   ├── pengembalian/menunggu-konfirmasi.blade.php (NEW)
│   └── reports/
│       ├── laporan-peminjaman.blade.php (NEW)
│       ├── laporan-pengembalian.blade.php (NEW)
│       ├── laporan-pengunjung.blade.php (NEW)
│       ├── laporan-anggota.blade.php (NEW)
│       └── pdf/ (PDF exports)
│           ├── laporan-peminjaman-pdf.blade.php
│           ├── laporan-pengembalian-pdf.blade.php
│           ├── laporan-pengunjung-pdf.blade.php
│           └── laporan-anggota-pdf.blade.php
└── ...

routes/web.php (updated - all routes documented)
```

---

## ✅ TESTING CHECKLIST

```
PEMINJAMAN FLOW:
□ Member submit peminjaman (status = menunggu_konfirmasi)
□ Stok tidak dikurangi setelah submit
□ Admin lihat /admin/peminjaman/menunggu
□ Admin click "Terima" → status = diambil, stok -1
□ Admin click "Tolak" + alasan → status = ditolak, stok utuh

PENGEMBALIAN FLOW:
□ Petugas buka /admin/pengembalian
□ Petugas pilih peminjaman aktif lalu isi form pengembalian
□ Pengembalian dibuat dengan denda otomatis dan status menunggu_konfirmasi
□ Admin lihat /admin/pengembalian/menunggu
□ Admin click "Terima" → status = diterima, stok +1
□ Denda ditampilkan dengan benar
□ Admin click "Tolak" + alasan → status = ditolak, stok tetap

LAPORAN FLOW:
□ /admin/reports/peminjaman - tampil dengan filter
□ /admin/reports/pengembalian - tampil dengan denda
□ /admin/reports/pengunjung - tampil dengan stats
□ /admin/reports/anggota - tampil dengan peminjaman count
□ Semua laporan bisa export PDF
```
