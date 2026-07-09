<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Denda Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .filter-info {
            margin-bottom: 15px;
            font-size: 11px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .summary {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            text-align: right;
        }
        .summary h3 {
            margin: 0;
            color: #d9534f;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Denda Keterlambatan</h2>
        <p>Sistem Informasi Perpustakaan Digital</p>
    </div>

    <div class="filter-info">
        <strong>Periode:</strong> 
        {{ $dari_tanggal ? \Carbon\Carbon::parse($dari_tanggal)->format('d/m/Y') : 'Awal' }} 
        s/d 
        {{ $sampai_tanggal ? \Carbon\Carbon::parse($sampai_tanggal)->format('d/m/Y') : 'Sekarang' }}
        <br>
        <strong>Dicetak pada:</strong> {{ now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Peminjam</th>
                <th width="25%">Judul Buku</th>
                <th width="12%">Target Kembali</th>
                <th width="12%">Aktual Kembali</th>
                <th width="11%" class="text-right">Denda (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengembalians as $index => $pengembalian)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pengembalian->created_at->format('d/m/Y') }}</td>
                    <td>
                        {{ $pengembalian->peminjaman->member->name ?? 'Terhapus' }}<br>
                        <small>{{ $pengembalian->peminjaman->member->nim ?? '-' }}</small>
                    </td>
                    <td>{{ Str::limit($pengembalian->peminjaman->book->judul ?? 'Terhapus', 40) }}</td>
                    <td>{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_kembali)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($pengembalian->tgl_kembali_aktual)->format('d/m/Y') }}</td>
                    <td class="text-right">{{ number_format($pengembalian->denda, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data denda pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <strong>Total Denda Terkumpul:</strong>
        <h3>Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
    </div>

    <div class="footer">
        Dokumen ini di-generate secara otomatis oleh sistem.
    </div>
</body>
</html>
