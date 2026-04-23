<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; margin-bottom: 5px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header p { margin: 3px 0; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f0f0f0; padding: 8px; text-align: left; font-size: 11px; border: 1px solid #ddd; font-weight: bold; }
        td { padding: 8px; font-size: 10px; border: 1px solid #ddd; }
        .text-center { text-align: center; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PEMINJAMAN BUKU</h1>
        <p><strong>Perpustakaan Digital</strong></p>
        <p>Tanggal Cetak: {{ now()->translatedFormat('d F Y H:i') }}</p>
        @if($dari_tanggal && $sampai_tanggal)
            <p>Periode: {{ \Carbon\Carbon::parse($dari_tanggal)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($sampai_tanggal)->translatedFormat('d F Y') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 10%">No. Antrian</th>
                <th style="width: 20%">Nama Member</th>
                <th style="width: 25%">Judul Buku</th>
                <th style="width: 10%">Tgl Pinjam</th>
                <th style="width: 10%">Tgl Kembali</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $key => $peminjaman)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $peminjaman->nomor_antrian }}</td>
                    <td>{{ $peminjaman->member?->name ?? 'N/A' }}</td>
                    <td>{{ $peminjaman->judul_buku }}</td>
                    <td class="text-center">{{ $peminjaman->tgl_pinjam->translatedFormat('d/m/Y') }}</td>
                    <td class="text-center">{{ $peminjaman->tgl_kembali->translatedFormat('d/m/Y') }}</td>
                    <td>{{ $peminjaman->statusLabel }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 11px;">
        <p><strong>Total Peminjaman:</strong> {{ $peminjamans->count() }}</p>
    </div>

    <div style="position: absolute; bottom: 20px; right: 30px; font-size: 10px;">
        <p>Dicetak oleh: Sistem Perpustakaan Digital</p>
    </div>
</body>
</html>
