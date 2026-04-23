# ⚡ QUICK REFERENCE GUIDE

## 🎯 3 Main Workflows

### 1️⃣ PEMINJAMAN (Member Request → Admin Confirm)
```
Member: /peminjaman 
  ↓ Fill form (buku, tgl pinjam, tgl kembali)
  ↓ Submit → Status: menunggu_konfirmasi, Stok: SAMA

Admin: /admin/peminjaman/menunggu
  ↓ Review request
  ↓ [Terima] → Status: diambil, Stok: -1
     ATAU
  ↓ [Tolak] + alasan → Status: ditolak, Stok: SAMA

Result: Member bisa ambil buku / member dapat notif ditolak
```

### 2️⃣ PENGEMBALIAN (Member Return → Admin Confirm)
```
Member: Datang ke perpustakaan dengan buku
  ↓ Petugas input pengembalian (kondisi, tgl aktual)
  ↓ Auto-calculate denda: Rp 5.000/minggu jika terlambat
  ↓ Status: menunggu_konfirmasi, Stok: SAMA

Admin: /admin/pengembalian/menunggu
  ↓ Review kondisi & denda
  ↓ [Terima] → Status: diterima, Stok: +1, Denda recorded
     ATAU
  ↓ [Tolak] + alasan → Status: ditolak, Stok: SAMA (member masih utang)

Result: Stok restored / Member harus selesaikan masalah
```

### 3️⃣ LAPORAN (Admin View & Export)
```
Admin: /admin/reports/{type}
  ↓ [Type: peminjaman, pengembalian, pengunjung, anggota]
  ↓ Filter: status, date range, search
  ↓ View paginated data (20/page)
  ↓ [Export PDF] → Download file

Result: Detailed reports with statistics
```

---

## 🗂️ QUICK ROUTES

### Member Routes
```
GET  /peminjaman                          Form peminjaman
POST /peminjaman                          Submit peminjaman
GET  /peminjaman/riwayat                  History & stats
GET  /peminjaman/riwayat/download-pdf     Download PDF history
GET  /peminjaman/baca/{book}              Read digital book
GET  /pengunjung/form                     Register as visitor
```

### Admin Routes - Confirmation
```
GET  /admin/peminjaman/menunggu           Pending loans to approve/reject
PUT  /admin/peminjaman/{id}/konfirmasi    Approve loan (reduce stock)
PUT  /admin/peminjaman/{id}/tolak         Reject loan (w/ reason)

GET  /admin/pengembalian/menunggu         Pending returns to approve/reject
PUT  /admin/pengembalian/{id}/terima      Accept return (restore stock)
PUT  /admin/pengembalian/{id}/tolak       Reject return (w/ reason)
```

### Admin Routes - Reports
```
GET  /admin/reports/peminjaman            Laporan Peminjaman
GET  /admin/reports/peminjaman/export-pdf Export Peminjaman as PDF

GET  /admin/reports/pengembalian          Laporan Pengembalian (+ denda)
GET  /admin/reports/pengembalian/export-pdf Export Pengembalian as PDF

GET  /admin/reports/pengunjung            Laporan Pengunjung
GET  /admin/reports/pengunjung/export-pdf Export Pengunjung as PDF

GET  /admin/reports/anggota               Laporan Anggota (+ peminjaman count)
GET  /admin/reports/anggota/export-pdf    Export Anggota as PDF
```

---

## 📊 Key Models & Methods

### Peminjaman Model
```php
// Scopes
->menuungguKonfirmasi()    // Where status = menunggu_konfirmasi
->diambil()                // Where status = diambil
->dikembalikan()           // Where status = dikembalikan
->ditolak()                // Where status = ditolak

// Attributes
$peminjaman->statusLabel   // Display text for status
$peminjaman->nomor_antrian // Queue number (ANT-2604001)
$peminjaman->tgl_pinjam    // Loan date
$peminjaman->tgl_kembali   // Return date
$peminjaman->status        // Current status

// Relationships
$peminjaman->member        // Related member
$peminjaman->book          // Related book
$peminjaman->pengembalian  // Linked return record
```

### Pengembalian Model
```php
// Static Method - Calculate Fine
Pengembalian::hitungDenda($tgl_kembali_target, $tgl_kembali_aktual)
// Returns: Rp.5000 × weeks_late

// Scopes
->menuungguKonfirmasi()    // Where status = menunggu_konfirmasi
->diterima()               // Where status = diterima
->ditolak()                // Where status = ditolak

// Attributes
$pengembalian->denda       // Fine amount (decimal)
$pengembalian->kondisi_buku // baik / rusak_ringan / rusak_berat
$pengembalian->status      // Current status
$pengembalian->admin_id    // Who approved/rejected

// Relationships
$pengembalian->peminjaman  // Related loan
$pengembalian->admin       // User who confirmed
```

### Controllers - Key Methods

#### PeminjamanController
```php
index()           // Show loan form with available books
store()           // Create new loan (status: menunggu_konfirmasi)
riwayat()         // Show member's loan history
downloadRiwayatPdf() // Download history as PDF

// Admin Confirmation Methods
indexMenungguKonfirmasi()    // List pending loans
konfirmasiPeminjaman()       // Approve loan (reduce stock)
tolakPeminjaman()            // Reject loan (with reason)
```

#### PengembalianController
```php
indexMenunggu()   // List pending returns
show()            // Show return details
terima()          // Accept return (restore stock)
tolak()           // Reject return (with reason)
```

#### AdminReportController
```php
laporanPeminjaman()          // View loan report
exportPeminjamanPdf()        // Export as PDF

laporanPengembalian()        // View return report (+ denda)
exportPengembalianPdf()      // Export as PDF

laporanPengunjung()          // View visitor report
exportPengunjungPdf()        // Export as PDF

laporanAnggota()             // View member report
exportAnggotaPdf()           // Export as PDF
```

---

## 🔄 COMMON WORKFLOWS

### Approve a Loan Request
```
1. Admin login → Dashboard
2. See widget "Peminjaman Menunggu: 5"
3. Click "Lihat Detail"
4. See table of pending loans
5. Click "Terima" button for specific loan
6. System: Update status → diambil, reduce stock
7. Member: Gets notified, ready to pickup book
```

### Reject a Loan Request
```
1. Admin on /admin/peminjaman/menunggu
2. Click "Tolak" button
3. Modal appears: "Tolak Peminjaman"
4. Fill reason: "Stok sedang dalam perbaikan"
5. Click "Tolak Peminjaman" button
6. System: Update status → ditolak, save reason
7. Member: Gets notification with rejection reason
```

### Accept a Return
```
1. Admin on /admin/pengembalian/menunggu
2. See pending returns with calculated fines
3. Click "Terima" button
4. System: Update status → diterima, restore stock
5. Dashboard widget updates: "Total Denda Hari Ini: Rp X"
6. Return is complete
```

### View & Export Loan Report
```
1. Admin click: /admin/reports/peminjaman
2. See statistics cards (Total, Pending, Active, Returned, Rejected)
3. Apply filters: Status = "dikembalikan", Date range
4. See paginated table results
5. Click "Export PDF" button
6. Download file: "Laporan_Peminjaman_2026-04-22_14-30-45.pdf"
```

---

## 💾 Database Essentials

### Status Values
```
Peminjaman:
- menunggu_konfirmasi (initial, waiting admin approval)
- diambil (approved by admin, member ready to take)
- dikembalikan (returned/expired)
- ditolak (rejected by admin)

Pengembalian:
- menunggu_konfirmasi (initial, waiting admin confirmation)
- diterima (accepted by admin, process complete)
- ditolak (rejected by admin, member still owes)
```

### Stock Management
```
CREATE Peminjaman:
  Stock: UNCHANGED (stays same until approval)

APPROVE Peminjaman (status→diambil):
  Stock: REDUCED BY 1
  Also update in both books & perpusses tables if exists

ACCEPT Pengembalian (status→diterima):
  Stock: INCREASED BY 1
  Also update in both books & perpusses tables if exists

REJECT Peminjaman/Pengembalian:
  Stock: NO CHANGE
```

### Denda Calculation
```
Formula: ceil((tgl_aktual - tgl_rencana) / 7) × Rp.5.000

Examples:
- 0-6 hari terlambat  = Rp 5.000
- 7-13 hari terlambat = Rp 10.000
- 14-20 hari terlambat = Rp 15.000
- 21+ hari terlambat  = Rp 20.000+
```

---

## 🧪 TESTING QUICK CHECKLIST

```
PEMINJAMAN:
□ Create peminjaman → Status menunggu_konfirmasi
□ Stock not reduced yet
□ Admin approve → Status diambil, stock -1
□ Admin reject → Status ditolak, stock unchanged

PENGEMBALIAN:
□ Create pengembalian → Denda calculated
□ Admin accept → Status diterima, stock +1
□ Admin reject → Status ditolak, stock unchanged
□ Denda shows in dashboard widget

LAPORAN:
□ All 4 reports load without errors
□ Filters work correctly
□ Pagination works (20/page)
□ PDF export generates valid file
□ PDF contains correct filtered data
```

---

## 📞 NEED HELP?

### Documentation Files
- `SYSTEM_FLOW.md` - Detailed step-by-step flows
- `VISUAL_FLOWS.md` - Diagrams & visual representations
- `CLEANUP_GUIDE.md` - Files to delete & maintenance

### Key Files to Understand
```
Controllers:
- app/Http/Controllers/Admin/AdminReportController.php (reports)
- app/Http/Controllers/PeminjamanController.php (loans)
- app/Http/Controllers/PengembalianController.php (returns)
- app/Http/Controllers/Admin/AdminRegistrationController.php (dashboard)

Views:
- resources/views/admin/dashboard/dashboard.blade.php (widgets)
- resources/views/admin/peminjaman/menunggu-konfirmasi.blade.php
- resources/views/admin/pengembalian/menunggu-konfirmasi.blade.php
- resources/views/admin/reports/laporan-*.blade.php (4 reports)

Routes:
- routes/web.php (all routes documented)

Models:
- app/Models/Peminjaman.php
- app/Models/Pengembalian.php
- app/Models/Member.php
```

---

**Last Updated:** April 22, 2026  
**Status:** ✅ All 5 Requirements Implemented  
**Next Steps:** Cleanup garbage files, then testing
