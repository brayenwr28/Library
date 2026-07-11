<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Riwayat Peminjaman Buku Universitas Metamedia</title>

<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #333;
}

/* CONTAINER */
.container {
    width: 100%;
    padding: 20px;
}

/* HEADER */
.header {
    text-align: center;
    margin-bottom: 20px;
    border-bottom: 2px solid #000;
    padding-bottom: 10px;
}

.header h1 {
    font-size: 18px;
    margin-bottom: 5px;
}

.header p {
    font-size: 11px;
}

/* MEMBER INFO */
.member-info {
    width: 100%;
    margin-bottom: 15px;
}

.member-info table {
    width: 100%;
}

.member-info td {
    padding: 4px;
}

.label {
    width: 25%;
    font-weight: bold;
}

/* STATISTIK */
.stats {
    margin: 15px 0;
}

.stats table {
    width: 100%;
    text-align: center;
    border-collapse: collapse;
}

.stats td {
    border: 1px solid #000;
    padding: 8px;
}

.stat-number {
    font-size: 16px;
    font-weight: bold;
}

/* JUDUL SECTION */
.section-title {
    margin: 15px 0 8px;
    font-weight: bold;
    border-bottom: 1px solid #000;
    padding-bottom: 4px;
}

/* TABLE */
table.data {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
}

table.data th,
table.data td {
    border: 1px solid #000;
    padding: 6px;
}

table.data th {
    background: #eee;
}

/* STATUS */
.status {
    font-weight: bold;
}

.menunggu_konfirmasi {
    color: #b45309;
}

.terpinjam {
    color: blue;
}

.dikembalikan {
    color: green;
}

.ditolak {
    color: #be123c;
}

/* FOOTER */
.footer {
    margin-top: 20px;
    font-size: 10px;
    text-align: center;
}

</style>
</head>

<body>
<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h1>RIWAYAT PEMINJAMAN BUKU</h1>
        <p>Perpustakaan Digital</p>
    </div>

    <!-- MEMBER INFO -->
    <div class="member-info">
        <table>
            <tr>
                <td class="label">Nama</td>
                <td>: {{ $member->name }}</td>
                <td class="label">Username</td>
                <td>: {{ $member->username }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>: {{ $member->email }}</td>
                <td class="label">No Identitas</td>
                <td>: {{ $member->member_id  ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td>: {{ $generatedAt }}</td>
                <td class="label">Tanggal</td>
                <td>: {{ now()->translatedFormat('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- STATISTIK -->
    @php
        $total = $peminjamans->count();
        $aktif = $peminjamans->where('status', 'diambil')->count();
        $selesai = $peminjamans->where('status', 'dikembalikan')->count();
    @endphp

    <div class="stats">
        <table>
            <tr>
                <td>
                    <div class="stat-number">{{ $total }}</div>
                    Total
                </td>
                <td>
                    <div class="stat-number">{{ $aktif }}</div>
                    Dipinjam
                </td>
                <td>
                    <div class="stat-number">{{ $selesai }}</div>
                    Dikembalikan
                </td>
            </tr>
        </table>
    </div>

    <!-- TABEL -->
    <div class="section-title">Daftar Peminjaman</div>

    @if($peminjamans->count() > 0)
    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Antrian</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->judul_buku }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') }}</td>
                <td>{{ $p->nomor_antrian }}</td>
                <td class="status {{ $p->status }}">
                    @if($p->status === 'diambil')
                        Disetujui
                    @elseif($p->status === 'dikembalikan')
                        Dikembalikan
                    @elseif($p->status === 'menunggu_konfirmasi')
                        Menunggu Konfirmasi
                    @elseif($p->status === 'ditolak')
                        Ditolak
                    @else
                        {{ ucfirst($p->status) }}
                    @endif
                </td>
                <td>
                    {{ $p->status === 'ditolak' ? ($p->catatan ?? '-') : '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p style="text-align:center; margin-top:10px;">Belum ada data peminjaman</p>
    @endif

    <!-- FOOTER -->
    <div class="footer">
        Dokumen ini merupakan bukti resmi riwayat peminjaman perpustakaan.
    </div>

</div>
</body>
</html>