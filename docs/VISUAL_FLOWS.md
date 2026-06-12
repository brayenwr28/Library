# 🎨 VISUAL FLOW DIAGRAMS

## 1. PEMINJAMAN FLOW (Sequence Diagram)

```
MEMBER                          SYSTEM                          ADMIN
  │                               │                               │
  ├─ Visit /peminjaman ──────────>│                               │
  │                               │ Show form + list buku         │
  │<─────── Form with books ───── │                               │
  │                               │                               │
  ├─ Fill & submit ──────────────>│                               │
  │                               │ Create Peminjaman             │
  │                               │ Status: menunggu_konfirmasi   │
  │                               │ Stock: NOT reduced yet        │
  │<─────── Success message ──────│                               │
  │                               │ Update Dashboard widget       │
  │                               ├──────────> Notify Admin       │
  │                               │            New request!       │
  │                               │                               │
  │                               │            Admin clicks link  │
  │                               │            /admin/peminjaman/ │
  │                               │<──────────┤                   │
  │                               │           menunggu            │
  │                               │                               │
  │                               │           Check request       │
  │                               │           details             │
  │                               │           Click: Terima/Tolak │
  │                               │                               │
  │                 ┌─────────────┤────────────────┬──────────┐  │
  │                 │             │                │          │  │
  │                 │ OPSI A: TERIMA              │ OPSI B: TOLAK
  │                 │             │                │          │  │
  │                 │             │                │          │  │
  │                 ├─ Status = diambil ──────────┤ Status = ditolak
  │                 │  Stock -= 1                 │ Stock = NO CHANGE
  │                 │  Member READY to take       │ Member rejected
  │                 │  Send notification ──────>  │ Send notif
  │<─────────────── │  "Ready to pickup"          │ "Ditolak - alasan"
  │                 │                             │
```

---

## 2. PENGEMBALIAN FLOW (Sequence Diagram)

```
MEMBER          PETUGAS/ADMIN INPUT      SYSTEM                    ADMIN
 │               (Front Office)          │                         │
 ├──Datang + buku──────────────>│        │                         │
 │                              │        │                         │
 │                              ├─ Buka /admin/pengembalian      │
 │                              ├─ Pilih peminjaman aktif        │
 │                              ├─ Isi form: tgl, kondisi, catat │
 │                              │        ├───────────────> Create Pengembalian
 │                              │        │                  Status: menunggu_konfirmasi
 │                              │        │                  Denda: dihitung otomatis
 │                              │<───────┤                  Simpan record
 │<──Bukti input pengembalian───┤        │                         │
 │                              │        ├───────────────────────>│ Dashboard widget update
 │                              │        │                        │
 │                              │        │        Admin buka /admin/pengembalian/menunggu
 │                              │        │<───────────────────────┤
 │                              │        │                        │
 │                              │        │          ┌───────────┬───────────┐
 │                              │        │          │           │           │
 │                              │        │       TERIMA      TOLAK        │
 │                              │        │          │           │           │
 │                              │        │  status=diterima  status=ditolak
 │                              │        │  peminjaman=      catatan alasan
 │                              │        │  dikembalikan     admin_id tercatat
 │                              │        │  stok += 1        stok tetap
 │                              │        │<─────────────────────────────────┘
 │<──────────── Selesai ────────┤        │
```

---

## 3. DASHBOARD WIDGETS (Home View)

```
╔════════════════════════════════════════════════════════════════════╗
║                      🎯 DASHBOARD ADMIN                            ║
╠════════════════════════════════════════════════════════════════════╣
║                                                                    ║
║  📊 Stats Cards (Top Row)                                          ║
║  ┌──────────────┬──────────────┬──────────────┬──────────────┐   ║
║  │ 📚 Total     │ 💿 Digital   │ 🏛️ Fisik     │ 👥 Members   │   ║
║  │ Buku         │ Buku         │ Buku         │              │   ║
║  │              │              │              │              │   ║
║  │ 450          │ 120          │ 330          │ 245          │   ║
║  └──────────────┴──────────────┴──────────────┴──────────────┘   ║
║                                                                    ║
║  ⚠️  PENDING ALERTS (New Section!)                                 ║
║  ┌────────────────────┬──────────────────┬────────────────────┐  ║
║  │ ⏳ PEMINJAMAN      │ 📦 PENGEMBALIAN │ 💰 DENDA           │  ║
║  │ MENUNGGU           │ MENUNGGU        │ HARI INI           │  ║
║  │                    │                  │                    │  ║
║  │ 8                  │ 5                │ Rp 45.000          │  ║
║  │ Perlu dikonfirmasi │ Perlu dikonfirmasi│                   │  ║
║  │                    │                  │                    │  ║
║  │ [Lihat Detail]     │ [Lihat Detail]  │ 22 Apr 2026       │  ║
║  └────────────────────┴──────────────────┴────────────────────┘  ║
║                                                                    ║
║  📈 Chart: Tren Peminjaman 30 hari                                ║
║  ┌──────────────────────────────────────────────────────────────┐ ║
║  │                     ╱╲                                       │ ║
║  │                    ╱  ╲      ╱╲                              │ ║
║  │        ╱╲          ╱    ╲    ╱  ╲                            │ ║
║  │       ╱  ╲        ╱      ╲  ╱    ╲     ╱╲                   │ ║
║  │      ╱    ╲      ╱        ╲╱      ╲   ╱  ╲                  │ ║
║  │─────╱──────╲────╱──────────────────╲─╱────╲─────            │ ║
║  └──────────────────────────────────────────────────────────────┘ ║
║                                                                    ║
║  ⚡ Aktivitas Terbaru                                              ║
║  ├─ 📚 "Pemrograman Python" oleh Ahmad                          ║
║  │  Aktivitas peminjaman • 2 jam lalu                           ║
║  │                                                               ║
║  ├─ ↩️  Pengembalian buku oleh Siti                             ║
║  │  Aktivitas pengembalian • 1 jam lalu                         ║
║  │                                                               ║
║  └─ 📚 "Database Design" oleh Budi                             ║
║     Aktivitas peminjaman • 30 menit lalu                        ║
║                                                                    ║
║  🎯 Akses Cepat                                                    ║
║  [+ Tambah Buku Digital] [+ Tambah Buku Fisik] [📋 Kelola Buku]  ║
║                                                                    ║
╚════════════════════════════════════════════════════════════════════╝
```

---

## 4. KONFIRMASI PEMINJAMAN PAGE

```
╔════════════════════════════════════════════════════════════════════╗
║           ⏳ PEMINJAMAN MENUNGGU KONFIRMASI                         ║
║                                                                    ║
║  Filter: [Status ▼] [Member ▼] [Dari ___] [Sampai ___] [Filter]  ║
║                                                                    ║
╠════════════════════════════════════════════════════════════════════╣
║ No.Antrian │ Member  │ Judul Buku │ Tanggal Pinjam │ Aksi         ║
╠════════════════════════════════════════════════════════════════════╣
║ ANT-2604001│ Ahmad   │ Python     │ 22-04 s/d 29-04│ [✓] [✗]    ║
║ ANT-2604002│ Siti    │ Database   │ 21-04 s/d 28-04│ [✓] [✗]    ║
║ ANT-2604003│ Budi    │ Web Dev    │ 20-04 s/d 27-04│ [✓] [✗]    ║
║ ANT-2604004│ Dewi    │ JavaScript │ 22-04 s/d 29-04│ [✓] [✗]    ║
║ ANT-2604005│ Edy     │ React      │ 21-04 s/d 28-04│ [✓] [✗]    ║
║                                                                    ║
║ ✓ = Terima (Update status → diambil, Kurangi stok)               ║
║ ✗ = Tolak (Modal appear → input alasan)                          ║
║                                                                    ║
║ Pagination: [< 1 2 3 >]                                           ║
╚════════════════════════════════════════════════════════════════════╝

┌─────────────────────────────────────┐
│     MODAL: TOLAK PEMINJAMAN         │
├─────────────────────────────────────┤
│                                     │
│ Anda akan menolak:                  │
│ Nomor: ANT-2604001                  │
│ Member: Ahmad                       │
│                                     │
│ Alasan Penolakan:                   │
│ ┌─────────────────────────────────┐ │
│ │ Stok sedang dalam perbaikan     │ │
│ │                                 │ │
│ │                                 │ │
│ └─────────────────────────────────┘ │
│                                     │
│          [Batal]  [Tolak]           │
└─────────────────────────────────────┘
```

---

## 5. KONFIRMASI PENGEMBALIAN PAGE

```
╔════════════════════════════════════════════════════════════════════╗
║          📦 PENGEMBALIAN MENUNGGU KONFIRMASI                       ║
║                                                                    ║
║  Filter: [Status ▼] [Dari ___] [Sampai ___] [Filter]              ║
║                                                                    ║
╠════════════════════════════════════════════════════════════════════╣
║ No.Antrian │ Member │ Buku  │ Kondisi │ Denda   │ Status │ Aksi   ║
╠════════════════════════════════════════════════════════════════════╣
║ ANT-2603015│ Ahmad  │ Python│ Baik    │ Rp 0    │ ⏳     │[✓][✗] ║
║ ANT-2603012│ Siti   │ DB    │ Rusak R │ Rp 5.000│ ⏳     │[✓][✗] ║
║ ANT-2603008│ Budi   │ Web   │ Baik    │ Rp 15K  │ ⏳     │[✓][✗] ║
║                                                                    ║
║ ✓ = Terima (Status → diterima, Stok +1, Catat denda)             ║
║ ✗ = Tolak (Modal appear → input alasan)                          ║
║                                                                    ║
╚════════════════════════════════════════════════════════════════════╝
```

---

## 6. LAPORAN PAGE TEMPLATE

```
╔════════════════════════════════════════════════════════════════════╗
║          📊 LAPORAN [PEMINJAMAN/PENGEMBALIAN/etc]                  ║
╠════════════════════════════════════════════════════════════════════╣
║                                                                    ║
║  📈 Statistics (Top Cards)                                         ║
║  ┌──────────────┬──────────────┬──────────────┬──────────────┐   ║
║  │ Total        │ Status 1     │ Status 2     │ Status 3     │   ║
║  │ 450          │ 45           │ 320          │ 85           │   ║
║  └──────────────┴──────────────┴──────────────┴──────────────┘   ║
║                                                                    ║
║  🔍 Filter Section                                                 ║
║  ┌────────────────────────────────────────────────────────────┐  ║
║  │ [Status ▼] [Dari ___] [Sampai ___] [Search ___] [Filter]   │  ║
║  │ [PDF Export]                                               │  ║
║  └────────────────────────────────────────────────────────────┘  ║
║                                                                    ║
║  📋 Data Table (Responsive)                                       ║
║  ┌────────────────────────────────────────────────────────────┐  ║
║  │ No │ Column1 │ Column2 │ Column3 │ Column4 │ Column5       │  ║
║  ├────────────────────────────────────────────────────────────┤  ║
║  │  1 │ Data    │ Data    │ Data    │ Data    │ Data          │  ║
║  │  2 │ Data    │ Data    │ Data    │ Data    │ Data          │  ║
║  │  3 │ Data    │ Data    │ Data    │ Data    │ Data          │  ║
║  │... │  ...    │  ...    │  ...    │  ...    │ ...           │  ║
║  │ 20 │ Data    │ Data    │ Data    │ Data    │ Data          │  ║
║  └────────────────────────────────────────────────────────────┘  ║
║                                                                    ║
║  Pagination: [< 1 2 3 >] Page 1 of 10                            ║
║                                                                    ║
╚════════════════════════════════════════════════════════════════════╝
```

---

## 7. DATA FLOW OVERVIEW

```
┌─────────────────────────────────────────────────────────────┐
│ INPUT ENDPOINTS                                             │
├─────────────────────────────────────────────────────────────┤
│ POST /peminjaman              → Create Peminjaman           │
│ POST /pengunjung              → Create Pengunjung           │
│ (Form submission from members & perpustakaan staff)         │
└─────────────────────────────────────────────────────────────┘
                        ↓
        ┌───────────────────────────────────┐
        │  DATABASE STORAGE                 │
        │  - peminjamans                    │
        │  - pengembalians                  │
        │  - pengunjungs                    │
        │  - members                        │
        │  - books                          │
        └───────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────────┐
│ ADMIN PROCESSING                                            │
├─────────────────────────────────────────────────────────────┤
│ PUT /admin/peminjaman/{id}/konfirmasi   → Approve/Reduce   │
│ PUT /admin/peminjaman/{id}/tolak        → Reject           │
│ PUT /admin/pengembalian/{id}/terima     → Accept/Restore   │
│ PUT /admin/pengembalian/{id}/tolak      → Reject           │
└─────────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────────┐
│ REPORTING                                                   │
├─────────────────────────────────────────────────────────────┤
│ GET /admin/reports/peminjaman           → View & Filter    │
│ GET /admin/reports/pengembalian         → View & Filter    │
│ GET /admin/reports/pengunjung           → View & Filter    │
│ GET /admin/reports/anggota              → View & Filter    │
│ GET /admin/reports/{type}/export-pdf    → Download PDF     │
└─────────────────────────────────────────────────────────────┘
```

---

## 8. STATUS TRANSITIONS

```
PEMINJAMAN:
menunggu_konfirmasi  ──[Admin Confirm]──>  diambil
                     ──[Admin Reject]──>    ditolak
                     ──[Auto Expire]──>     dikembalikan (jika lewat batas)

PENGEMBALIAN:
menunggu_konfirmasi  ──[Admin Accept]──>   diterima
                     ──[Admin Reject]──>    ditolak

DENDA SYSTEM:
Tgl Kembali Rencana < Tgl Kembali Aktual
                     ──[Calculate]──>       Rp 5.000 × ceil(hari_lambat/7)
```
