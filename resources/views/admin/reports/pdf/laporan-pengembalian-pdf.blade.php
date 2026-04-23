<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; margin-bottom: 5px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header p { margin: 3px 0; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f0f0f0; padding: 8px; text-align: left; font-size: 11px; border: 1px solid #ddd; font-weight: bold; }
        td { padding: 8px; font-size: 10px; border: 1px solid #ddd; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENGEMBALIAN BUKU</h1>
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
                <th style="width: 20%">Judul Buku</th>
                <th style="width: 10%">Kondisi</th>
                <th style="width: 12%">Denda</th>
                <th style="width: 13%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengembalians as $key => $pengembalian)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $pengembalian->peminjaman?->nomor_antrian }}</td>
                    <td>{{ $pengembalian->peminjaman?->member?->name }}</td>
                    <td>{{ $pengembalian->peminjaman?->judul_buku }}</td>
                    <td class="text-center">
                        @php
                            $kondisiLabel = match($pengembalian->kondisi_buku) {
                                'baik' => 'Baik',
                                'rusak_ringan' => 'Rusak Ringan',
                                'rusak_berat' => 'Rusak Berat',
                                default => 'Tidak Diketahui'
                            };
                        @endphp
                        {{ $kondisiLabel }}
                    </td>
                    <td class="text-right">Rp {{ number_format($pengembalian->denda ?? 0, 0, ',', '.') }}</td>
                    <td class="text-center">{{ ucfirst(str_replace('_', ' ', $pengembalian->status)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #f0f0f0; font-weight: bold;">
                <td colspan="5" class="text-right" style="border-top: 2px solid #333;">TOTAL DENDA:</td>
                <td class="text-right" style="border-top: 2px solid #333;">Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px; font-size: 11px;">
        <p><strong>Total Pengembalian:</strong> {{ $pengembalians->count() }}</p>
    </div>

    <div style="position: absolute; bottom: 20px; right: 30px; font-size: 10px;">
        <p>Dicetak oleh: Sistem Perpustakaan Digital</p>
    </div>
</body>
</html>
